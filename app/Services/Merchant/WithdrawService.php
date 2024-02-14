<?php

namespace App\Services\Merchant;

use App\Enums\NotiTypeReceive;
use App\Enums\WithdrawMethod;
use App\Enums\WithdrawRequestMethod;
use App\Enums\WithdrawStatus;
use App\Enums\FiatAccountType;
use App\Events\NeedSendMail;
use App\Repositories\CryptoWithdrawAccountRepository;
use App\Repositories\EpayReceiveNotiFormRepository;
use App\Repositories\FiatWithdrawAccountRepository;
use App\Repositories\MerchantStoreRepository;
use App\Repositories\WithdrawRepository;
use App\Services\BalanceService;
use App\Services\TigerGateway\TigerGatewayService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WithdrawService
{
    protected WithdrawRepository $withdrawRepository;

    protected FiatWithdrawAccountRepository $fiatWithdrawAccountRepo;

    protected CryptoWithdrawAccountRepository $cryptoWithdrawAccountRepo;

    protected EpayReceiveNotiFormRepository $epayReceiveNotiFormRepository;

    protected MerchantStoreRepository $merchantStoreRepository;

    protected BalanceService $balanceService;

    protected TigerGatewayService $tigerGatewayService;

    public function __construct(
        WithdrawRepository $withdrawRepository,
        FiatWithdrawAccountRepository $fiatWithdrawAccountRepo,
        CryptoWithdrawAccountRepository $cryptoWithdrawAccountRepo,
        EpayReceiveNotiFormRepository $epayReceiveNotiFormRepository,
        MerchantStoreRepository $merchantStoreRepository,
        BalanceService $balanceService,
        TigerGatewayService $tigerGatewayService,
    ) {
        $this->withdrawRepository = $withdrawRepository;
        $this->fiatWithdrawAccountRepo = $fiatWithdrawAccountRepo;
        $this->cryptoWithdrawAccountRepo = $cryptoWithdrawAccountRepo;
        $this->epayReceiveNotiFormRepository = $epayReceiveNotiFormRepository;
        $this->merchantStoreRepository = $merchantStoreRepository;
        $this->balanceService = $balanceService;
        $this->tigerGatewayService = $tigerGatewayService;
    }

    public function getHistories($filter): mixed
    {
        return $this->withdrawRepository->getHistories($filter);
    }

    public function totalMoneyWithdraw($cond)
    {
        return $this->withdrawRepository->totalMoneyWithdraw($cond);
    }

    public function withdrawStatistic($cond)
    {
        return $this->withdrawRepository->withdrawStatistic($cond);
    }

    public function getWithdrawHistory($id)
    {
        return $this->withdrawRepository->getWithdrawHistory($id);
    }

    public function getFiatAccountDefault($id)
    {
        return $this->fiatWithdrawAccountRepo->findByField('merchant_store_id', $id)->first();
    }

    public function getCryptoAccountDefault($id)
    {
        return $this->cryptoWithdrawAccountRepo->findByField('merchant_store_id', $id)->first();
    }

    public function createRequestWithdraw($request)
    {
        DB::beginTransaction();
        try {
            $dataWithdraw = $request->only(
                'merchant_store_id',
                'withdraw_method',
                'withdraw_status',
                'asset',
                'fiat_withdraw_account_id',
                'crypto_withdraw_account_id',
                'company_member_code',
                'note',
            );

            $withdrawMethod = $request->withdraw_method;
            $merchantStoreId = $request->merchant_store_id;
            switch ($withdrawMethod) {
                case WithdrawMethod::BANKING->value:
                    $bankingInfo = $request->only([
                        'financial_institution_name',
                        'bank_code',
                        'branch_code',
                        'branch_name',
                        'bank_account_type',
                        'bank_account_number',
                        'bank_account_holder',
                    ]);
                    $dataWithdraw = array_merge($dataWithdraw, [
                        'bank_info' => $bankingInfo,
                        'withdraw_name' => $request->financial_institution_name . ' ' . $request->bank_account_number,
                    ]);
                    break;
                case WithdrawMethod::CRYPTO->value:
                    $cryptoInfo = $request->only([
                        'asset',
                        'wallet_address',
                        'network',
                        'note_crypto',
                    ]);
                    $dataWithdraw = array_merge($dataWithdraw, [
                        'crypto_info' => $cryptoInfo,
                        'withdraw_name' => $request->network . ' ' . $request->wallet_address,
                    ]);
                    break;
                default:
                    break;
            }

            $countNumber = $this->withdrawRepository->where('merchant_store_id', $merchantStoreId)->count();
            $merchantStore = $this->merchantStoreRepository->find($merchantStoreId);
            $maxAmount = $this->balanceService->getBalanceSummary($merchantStoreId, $request->asset);

            if ((float) $request->amount > $maxAmount) {
                throw new Exception(__('merchant.withdraw.over_amount'), Response::HTTP_BAD_REQUEST);
            }

            $orderId = formatAccountId($merchantStore->merchant_code) . Carbon::now()->format('_Ymd_') . $countNumber + 1;

            if (!empty($request->auth_submit) and $request->auth_submit == 'epay') {
                $dataWithdraw = array_merge($dataWithdraw, [
                    'withdraw_request_method' => WithdrawRequestMethod::REQUEST_EPAY->value,
                    "approve_datetime" => Carbon::now(),
                    'amount' => (float) $request->amount,
                    'order_id' => $orderId,
                ]);
                if ($withdrawMethod !== WithdrawMethod::BANKING->value)
                    $dataWithdraw['withdraw_status'] = WithdrawStatus::SUCCEEDED->value;
            } else {
                $dataWithdraw = array_merge($dataWithdraw, [
                    'withdraw_request_method' => WithdrawRequestMethod::REQUEST_MERCHANT->value,
                    'withdraw_status' => WithdrawStatus::WAITING_APPROVE->value,
                    'amount' => (float) $request->amount,
                    'order_id' => $orderId,
                ]);
            }

            $result = $this->withdrawRepository->create($dataWithdraw);

            if (!empty($request->auth_submit) and $request->auth_submit == 'epay' and $withdrawMethod == WithdrawMethod::BANKING->value) {
                $dataBank = $result["bank_info"];
                $bankType = match ($dataBank["bank_account_type"]) {
                    FiatAccountType::TERM_DEPOSIT->value => "定期",
                    FiatAccountType::CURRENT->value => "当座",
                    default => "普通",
                };
                $dataTiger = [
                    "transaction_id" => $result['id'],
                    "bank_name" => $dataBank["financial_institution_name"],
                    "bank_code" => $dataBank["bank_code"],
                    "branch_name" => $dataBank["branch_name"],
                    "branch_code" => $dataBank["branch_code"],
                    "account_type" => $bankType,
                    "account_number" => $dataBank["bank_account_number"],
                    "account_name" => $dataBank["bank_account_holder"],
                    "amount" => (int) $result["amount"],
                    "status" => "applying",
                ];
                $response = $this->tigerGatewayService->postWithdrawal($dataTiger);

                if ($response->hasError()) {
                    Log::error($response->getErrorReason());
                    return [
                        "status" => false,
                        "message" => __('common.tiger_service_fail')
                    ];
                }
                $this->withdrawRepository->update(['withdraw_status' => WithdrawStatus::SUCCEEDED, "approve_datetime" => Carbon::now()], $result['id']);
            }

            if ($result) {
                event(new NeedSendMail($result, NotiTypeReceive::WITHDRAWAL->value));
            }
            DB::commit();

            return $result;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            throw new Exception ($e->getMessage());
        }
    }

    public function updateWithdrawHistory($request, $id)
    {
        DB::beginTransaction();
        try {
            $withdraw = $this->withdrawRepository->with('merchantStore')->find($id);
            $maxAmount = $this->balanceService->getCurrentBalance($withdraw->merchantStore, $withdraw->asset);
            if ((float) $request->amount > $maxAmount + $withdraw->amount) {
                throw new Exception(__('merchant.withdraw.over_amount'));
            }
            if ($withdraw->withdraw_status != WithdrawStatus::WAITING_APPROVE->value) {
                throw new Exception(__('common.error.error_has_occurred'));
            }

            $dataWithdraw = $request->only(
                'company_member_code',
                'note',
                'amount'
            );
            $result = $this->withdrawRepository->update($dataWithdraw, $id);
            DB::commit();

            return $result;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            throw $e;
        }
    }

    public function deleteWithdrawHistory($request, $id)
    {
        DB::beginTransaction();
        try {
            $withdraw = $this->withdrawRepository->find($id);
            if ($withdraw->withdraw_status != WithdrawStatus::WAITING_APPROVE->value) {
                throw new Exception(__('common.error.error_has_occurred'));
            }

            $result = $this->withdrawRepository->delete($id);
            DB::commit();

            return $result;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            throw $e;
        }
    }
}