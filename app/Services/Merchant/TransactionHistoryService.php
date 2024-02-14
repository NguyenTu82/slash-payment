<?php

namespace App\Services\Merchant;

use App\Repositories\TransactionHistoryRepository;
use App\Repositories\MerchantStoreRepository;
use App\Enums\TransactionHistoryPaymentStatus;
use App\Models\TransactionHistory;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentSuccess;
use App\Enums\TransactionHistoryMoneyUnit;
use App\Enums\TransactionHistoryCryptoUnit;
use App\Enums\TransactionHistoryChainID;
use App\Enums\TransactionHistoryNetwork;
use App\Enums\TransactionHistoryRequesMethod;
use App\Exports\TransactionHistoryExport;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Exception;

class TransactionHistoryService
{
    protected TransactionHistoryRepository $transactionHistoryRepository;
    protected MerchantStoreRepository $merchantStoreRepository;

    public function __construct(
        TransactionHistoryRepository $transactionHistoryRepository,
        MerchantStoreRepository $merchantStoreRepository,
    ) {
        $this->transactionHistoryRepository = $transactionHistoryRepository;
        $this->merchantStoreRepository = $merchantStoreRepository;
    }

    public function findTransactionHistories($queryParams, $request)
    {
        // query data
        $transactionHistories = $this->transactionHistoryRepository->findTransactionHistories($queryParams);
        $data_csv = $transactionHistories->get();

        $transactionHistories = $transactionHistories->paginate($request->per_page ?? config('const.LIMIT_PAGINATION'));
        $transactionHistories->appends($request->toArray());

        $arr_trans = [
            "transactionHistories" => $transactionHistories,
            "data_csv" => $data_csv,
        ];
        return $arr_trans;
    }

    public function findTransactionById($id)
    {
        return $this->transactionHistoryRepository->find($id);
    }

    public function deleteTransactionById($id, $status)
    {
        try {
            DB::beginTransaction();
            $transaction = $this->transactionHistoryRepository->find($id)->delete();
            if ($status == TransactionHistoryPaymentStatus::SUCCESS->value) {
                $payment = PaymentSuccess::where('transaction_history_id', $id)->delete();
            }
            DB::commit();
            return $transaction;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function upateTransactionById($id, $trans_id, $request)
    {
        try {
            DB::beginTransaction();
            $status = $request->paymentStatusForm;
            $data = [
                'transaction_date' => Carbon::parse($request->dateRequestForm),
                'payment_amount' => $request->paymentAmountForm,
                'payment_asset' => $request->paymentAssetForm,
                'received_amount' => $request->receivedAmountForm,
                'received_asset' => $request->receivedAssetForm,
                'network' => $request->networkForm,
                'request_method' => $request->requestMethodForm,
                'payment_status' => $status,
                'payment_success_datetime' => Carbon::parse($request->paymentSuccessDatetimeForm),
            ];
            $transaction = $this->transactionHistoryRepository->find($trans_id)->update($data);

            if ($request->paymentStatusForm == TransactionHistoryPaymentStatus::SUCCESS->value) {
                $data_payment_success = [
                    'transaction_history_id' => $trans_id,
                    'merchant_store_id' => $id,
                    'payment_amount' => $request->paymentAmountForm,
                    'payment_asset' => $request->paymentAssetForm,
                    'received_amount' => $request->receivedAmountForm,
                    'received_asset' => $request->receivedAssetForm,
                    'network' => $request->networkForm,
                    'request_method' => $request->requestMethodForm,
                ];
                $payment = PaymentSuccess::query()->firstOrcreate($data_payment_success);
            }

            DB::commit();
            return $transaction;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function transStatistic($cond)
    {
        return $this->transactionHistoryRepository->transStatistic($cond);
    }

    public function updateDataWhenCallback($request)
    {
        DB::beginTransaction();
        try {
            // process get network
            if ($request->chain_id == TransactionHistoryChainID::ETH_CHAIN_ID->value || $request->chain_id == TransactionHistoryChainID::ETH_RINKEBY_TESTNET_CHAIN_ID->value)
                $network = TransactionHistoryNetwork::ETH->value;
            else if ($request->chain_id == TransactionHistoryChainID::BNB_CHAIN_ID->value || $request->chain_id == TransactionHistoryChainID::BNB_TESTNET_CHAIN_ID->value)
                $network = TransactionHistoryNetwork::BNB->value;
            else if ($request->chain_id == TransactionHistoryChainID::MATIC_CHAIN_ID->value || $request->chain_id == TransactionHistoryChainID::MATIC_TESTNET_CHAIN_ID->value)
                $network = TransactionHistoryNetwork::Matic->value;
            else if ($request->chain_id == TransactionHistoryChainID::AVAX_CHAIN_ID->value || $request->chain_id == TransactionHistoryChainID::AVAX_TESTNET_CHAIN_ID->value)
                $network = TransactionHistoryNetwork::AVAX->value;
            else if ($request->chain_id == TransactionHistoryChainID::FTM_CHAIN_ID->value || $request->chain_id == TransactionHistoryChainID::FTM_TESTNET_CHAIN_ID->value)
                $network = TransactionHistoryNetwork::FTM->value;
            else if ($request->chain_id == TransactionHistoryChainID::ARBITRUM_ETH_CHAIN_ID->value || $request->chain_id == TransactionHistoryChainID::ARBITRUM_ETH_TESTNET_CHAIN_ID->value)
                $network = TransactionHistoryNetwork::ARBITRUM_ETH->value;
            else if ($request->chain_id == TransactionHistoryChainID::SOL_CHAIN_ID->value || $request->chain_id == TransactionHistoryChainID::SOL_TESTNET_CHAIN_ID->value)
                $network = TransactionHistoryNetwork::SOL->value;
            else
                $network = '';

            $tranData = $this->transactionHistoryRepository->where('order_code', $request->order_code)->first();
            $merchantData = $this->merchantStoreRepository->find($tranData->merchant_store_id);
            $generate_params = [
                "order_code" => $request->order_code,
                "amount" => $request->amount,
                "hash_token" => $merchantData->hash_token
            ];
            $raw = implode("::", $generate_params);
            $verify_token = hash("sha256", $raw);
            if($verify_token != $request->verify_token) {
                throw new Exception(__('verify token is incorrect'), 400);
            }

            if ($tranData->count() > 0){
                $data = [
                    "callback_logs" => json_encode($request->all()),
                    "hash" => $request->transaction_hash,
                    "received_amount" => $request->amount,
                    "received_asset" => $request->symbol,
                    "network" => $network,
                    "payment_status" => $request->result ? 'success' : 'cancelled',
                    "payment_success_datetime" => Carbon::now(),
                ];
                $result = $tranData->update($data);
            }

            DB::commit();
            return [
                "status" => true,
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return [
                "status" => false,
                "messages" => $e->getMessage(),
            ];
        }
    }

    public function findTransactionByOrderCode($data)
    {
        return $this->transactionHistoryRepository->where('order_code', $data)->firstOrFail();
    }
}