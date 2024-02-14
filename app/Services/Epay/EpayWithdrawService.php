<?php

namespace App\Services\Epay;

use App\Enums\FiatAccountType;
use App\Enums\WithdrawMethod;
use App\Enums\WithdrawStatus;
use App\Jobs\SendEmailJob;
use App\Mail\SendDeclineMail;
use App\Repositories\EpayWithdrawRepository;
use App\Services\BalanceService;
use App\Services\Merchant\MerchantStoreService;
use App\Services\TigerGateway\TigerGatewayService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class EpayWithdrawService
{
    protected EpayWithdrawRepository $epayWithdrawRepository;

    protected TigerGatewayService $tigerGatewayService;

    protected BalanceService $balanceService;

    protected MerchantStoreService $merchantStoreService;

    public function __construct(
        EpayWithdrawRepository $epayWithdrawRepository,
        TigerGatewayService $tigerGatewayService,
        BalanceService $balanceService,
        MerchantStoreService $merchantStoreService,
    ) {
        $this->epayWithdrawRepository = $epayWithdrawRepository;
        $this->tigerGatewayService = $tigerGatewayService;
        $this->balanceService = $balanceService;
        $this->merchantStoreService = $merchantStoreService;
    }

    /**
     * @param $filter
     * @return mixed
     */
    public function getHistories($filter)
    {
        return $this->epayWithdrawRepository->getHistories($filter);
    }

    public function totalMoneyWithdraw($cond)
    {
        return $this->epayWithdrawRepository->totalMoneyWithdraw($cond);
    }

    public function withdrawStatistic($cond)
    {
        return $this->epayWithdrawRepository->withdrawStatistic($cond);
    }

    public function getWithdrawHistory($id)
    {
        return $this->epayWithdrawRepository->getWithdrawHistory($id);
    }

    public function updateWithdraw($request, $id): bool
    {
        $dataWithdraw = $this->epayWithdrawRepository->with('merchantStore')->find($id);
        $maxAmount = $this->balanceService->getCurrentBalance($dataWithdraw->merchantStore, $dataWithdraw->asset);
        if ((float) $request->amount > $maxAmount + $dataWithdraw->amount){
            return false;
        }

        $this->epayWithdrawRepository->update([
            'amount' => (float) $request->amount,
            'note' => $request->note,
            'company_member_code' => $request->company_member_code,
        ], $id);

        return true;
    }

    public function approve($id): array
    {
        $type = "";
        $data = $this->epayWithdrawRepository->getWithdrawHistory($id);
        if ($data["withdraw_method"] == WithdrawMethod::BANKING->value)
        {
            $type = "approve_withdraw_bank_success";
            $dataBank = $data["bank_info"];
            $bankType = match ($dataBank["bank_account_type"]) {
                FiatAccountType::TERM_DEPOSIT->value => "定期",
                FiatAccountType::CURRENT->value => "当座",
                default => "普通",
            };

            $dataTiger = [
                "transaction_id" => $id,
                "bank_name" => $dataBank["financial_institution_name"],
                "bank_code" => $dataBank["bank_code"],
                "branch_name" => $dataBank["branch_name"],
                "branch_code" => $dataBank["branch_code"],
                "account_type" => $bankType,
                "account_number" => $dataBank["bank_account_number"],
                "account_name" => $dataBank["bank_account_holder"],
                "amount" => (int) $data["amount"],
                "status" => "approved",
            ];

            $response = $this->tigerGatewayService->postWithdrawal($dataTiger);

            if ($response->hasError()) {
                Log::error($response->getErrorReason());
                return [
                    "status" => false,
                    "message" => __('common.tiger_service_fail')
                ];
            }
            $this->epayWithdrawRepository->update(['withdraw_status' => WithdrawStatus::SUCCEEDED, "approve_datetime" => Carbon::now()], $id);
        }

        if ($data["withdraw_method"] == WithdrawMethod::CRYPTO->value) {
            $this->epayWithdrawRepository->update([
                "withdraw_status" => WithdrawStatus::SUCCEEDED,
                "approve_datetime" => Carbon::now()
            ], $id);
            $type = "approve_withdraw_cash_crypto_success";
        }

        if ($data["withdraw_method"] == WithdrawMethod::CASH->value) {
            $this->epayWithdrawRepository->update([
                "withdraw_status" => WithdrawStatus::SUCCEEDED,
                "approve_datetime" => Carbon::now()
            ], $id);
            $type = "approve_withdraw_cash_crypto_success";
        }

        return [
            "status" => true,
            "type" => $type
        ];
    }

    /**
     * Case admin E-pay reject withdraw request
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function decline($id): mixed
    {
        try {
            $withdrawRequest = $this->epayWithdrawRepository->with('merchantStore')->find($id);
            $merchantInfo = $this->merchantStoreService->findDataMerchantById($withdrawRequest->merchantStore->id);
            $emailOfOwner = $merchantInfo->merchantOwner->email;
            $sendData = []; // Todo

            try {
                SendEmailJob::dispatch(new SendDeclineMail($sendData), $emailOfOwner)->onQueue('emails');
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }

            return $this->epayWithdrawRepository->update(['withdraw_status' => WithdrawStatus::DENIED], $id);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function deleteWithdraw($id): void
    {
        $this->epayWithdrawRepository->delete($id);
    }
}
