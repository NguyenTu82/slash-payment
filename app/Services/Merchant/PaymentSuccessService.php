<?php

namespace App\Services\Merchant;

use App\Repositories\PaymentSuccessRepository;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentSuccessService
{
    protected PaymentSuccessRepository $paymentSuccessRepository;

    public function __construct(
        PaymentSuccessRepository $paymentSuccessRepository
    ) {
        $this->paymentSuccessRepository = $paymentSuccessRepository;
    }

    public function totalTransactions($cond)
    {
        return $this->paymentSuccessRepository->totalTransactions($cond);
    }

    public function totalCryptoReceive($cond)
    {
        return $this->paymentSuccessRepository->totalCryptoReceive($cond);
    }

    public function paymentSuccessStatistic($cond)
    {
        return $this->paymentSuccessRepository->paymentSuccessStatistic($cond);
    }

    public function getQueryPaymentSuccessByType($request)
    {
        $totalReceived = $this->paymentSuccessRepository->getQueryPaymentSuccessByType($request, "received");
        $totalPayment = $this->paymentSuccessRepository->getQueryPaymentSuccessByType($request, "payment");
        $graph = $this->paymentSuccessRepository->getQueryPaymentSuccessByType($request, "graph");

        if (isset($request->startDateRequest) and isset($request->endDateRequest)) {
            $startTime = Carbon::parse($request->startDateRequest);
            $endTime = Carbon::parse($request->endDateRequest);
        } elseif (isset($request->startDateRequest) and !isset($request->endDateRequest)) {
            $startTime = Carbon::parse($request->startDateRequest);
            $endTime = Carbon::parse($request->startDateRequest)->addDays(30);
        } elseif (!isset($request->startDateRequest) and isset($request->endDateRequest)) {
            $startTime = Carbon::parse($request->endDateRequest)->subDays(30);
            $endTime = Carbon::parse($request->endDateRequest);
        } elseif (
            !isset($request->startDateRequest) and !isset($request->endDateRequest) and
            !isset($request->startDatePayment) and !isset($request->endDatePayment)
        ) {
            $startTime = Carbon::now()->startOfMonth();
            $endTime = Carbon::now()->endOfMonth();
        } elseif (count($graph) >= 1) {
            $startTime = Carbon::createFromFormat('m月d日', $graph->min('date'));
            $endTime = Carbon::createFromFormat('m月d日', $graph->max('date'));
        }

        $labels = [];
        $USDTDayReceived = [];
        $yenDayPayment = [];
        $dayTrans = [];
        if (isset($startTime) and isset($endTime)) {
            while ($startTime <= $endTime) {
                if (app()->getLocale() === 'ja')
                    $labels[] = $startTime->format('m月d日');
                else
                    $labels[] = $startTime->format('m/d');

                $startTime->addDay();
                $USDTDayReceived[] = 0;
                $yenDayPayment[] = 0;
                $dayTrans[] = 0;
            }
            foreach ($graph as $value) {
                $key = array_search($value['date'], $labels);
                $USDTDayReceived[$key] = $value["sum_received_amount"];
                $yenDayPayment[$key] = $value["sum_payment_amount"];
                $dayTrans[$key] = $value["count"];

            }
        }

        $arrPaymentSuccess = [
            "totalReceived" => $totalReceived->toArray()[0],
            "totalPayment" => $totalPayment->toArray()[0],
            "totalTrans" => $totalReceived->pluck("count")->toArray()[0],
            "USDTDayReceived" => $USDTDayReceived,
            "yenDayPayment" => $yenDayPayment,
            "dayTrans" => $dayTrans,
            "label" => $labels,
        ];
        return $arrPaymentSuccess;
    }

    public function createDataWhenCallback($data)
    {
        DB::beginTransaction();
        try {
            $data_payment = [
                'transaction_history_id' => $data->id,
                'merchant_store_id' => $data->merchant_store_id,
                'payment_amount' => $data->payment_amount,
                'payment_asset' => $data->payment_asset,
                'received_amount' => $data->received_amount,
                'received_asset' => $data->received_asset,
                'network' => $data->network,
                'request_method' => $data->request_method,
            ];
            $this->paymentSuccessRepository->create($data_payment);
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
}