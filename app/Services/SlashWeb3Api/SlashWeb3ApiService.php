<?php

namespace App\Services\SlashWeb3Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use App\Services\SlashWeb3Api\Response;
use Exception;
use Closure;
use Illuminate\Support\Str;
use App\Repositories\TransactionHistoryRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SlashWeb3ApiService
{
    use SlashWeb3ApiClient;

    const REQUEST_PAYMENT_API = "/api/v1/payment/receive";

    protected TransactionHistoryRepository $transactionHistoryRepository;

    public function __construct(
        TransactionHistoryRepository $transactionHistoryRepository,
    ) {
        $this->transactionHistoryRepository = $transactionHistoryRepository;
    }

    public function createQRForPayment($amount)
    {
        $merchant = auth('merchant')->user()->getMerchantStore()->first();
        $hash_token = $merchant->hash_token;
        $auth_token = $merchant->auth_token;
        if(empty($hash_token) or empty($auth_token)){
            throw new Exception(__('common.error.auth_and_hash_token_not_exist'), 400);
        }

        $this->setBearer($auth_token);
        $order_code = Str::uuid()->toString();

        //data save in transaction histories
        DB::beginTransaction();
        try {
            $data = [
                'merchant_store_id' => $merchant->id,
                'transaction_date' => Carbon::now(),
                'payment_amount' => $amount,
                'payment_asset' => 'JPY',
                'request_method' => 'from_merchant',
                'payment_status' => 'requested',
                'order_code' => $order_code,
            ];
            $result = $this->transactionHistoryRepository->create($data);
            DB::commit();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception(__('common.error.process_failed'), 400);
        }

        // Generate verify token
        $generate_params = [
            "order_code" => $order_code,
            "amount" => $amount,
            "hash_token" => $hash_token
        ];
        $raw = implode("::", $generate_params);
        $verify_token = hash("sha256", $raw);

        // Data to be sent to api
        $request_params = [
            "identification_token" => $auth_token,
            "order_code" => $order_code,
            "amount" => $amount,
            "verify_token" => $verify_token,
            "amount_type" => 'JPY'
        ];
        return new Response($this->request(self::REQUEST_PAYMENT_API, array_merge($request_params)));
    }
}