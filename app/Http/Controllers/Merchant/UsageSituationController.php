<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Http\Request;
use App\Services\Merchant\TransactionHistoryService;
use App\Services\Merchant\PaymentSuccessService;
use App\Exports\TransactionHistoryExport;
use Exception;
use Illuminate\Support\Facades\Log;

class UsageSituationController extends Controller
{
    protected TransactionHistoryService $transactionHistoryService;
    protected PaymentSuccessService $paymentSuccessService;

    public function __construct(
        TransactionHistoryService $transactionHistoryService,
        PaymentSuccessService $paymentSuccessService
    ) {
        $this->transactionHistoryService = $transactionHistoryService;
        $this->paymentSuccessService = $paymentSuccessService;
    }

    public function index(Request $request): View|BinaryFileResponse
    {
        $merchantStores = auth("merchant")->user()->merchantStores()->get();
        $queryParams = (object) $request->query();
        $queryParams->startAmount = isset($queryParams->startAmount) ? str_replace(',','',$queryParams->startAmount) : null;
        $queryParams->endAmount = isset($queryParams->endAmount) ? str_replace(',','',$queryParams->endAmount) : null;

        if (!isset($queryParams->merchant_store_id)) {
            $merchantStoresIds = $merchantStores->pluck('id');
            $queryParams->merchantStoresIds = $merchantStoresIds;
        }

        // query data for card and graph
        $arrPaymentSuccess = $this->paymentSuccessService->getQueryPaymentSuccessByType($queryParams);

        // query data for table
        $arrTrans = $this->transactionHistoryService->findTransactionHistories($queryParams, $request);

        // download csv
        if ($request->has('csv')) {
            $export = new TransactionHistoryExport($arrTrans['data_csv']);

            return $export->download('epay_usage_situation_' . date('YmdHis') . '.csv')
                ->deleteFileAfterSend(true);
        }

        return view(
            'merchant.usage_situation.index',
            [
                'merchantStores' => $merchantStores,
                'transactionHistories' => $arrTrans['transactionHistories'],
                'request' => $request,
                'dayTrans' => $arrPaymentSuccess['dayTrans'],
                'countTrans' => $arrPaymentSuccess['totalTrans'],
                'USDTDayReceived' => $arrPaymentSuccess['USDTDayReceived'],
                'totalReceived' => $arrPaymentSuccess['totalReceived'],
                'yenDayPayment' => $arrPaymentSuccess['yenDayPayment'],
                'totalPayment' => $arrPaymentSuccess['totalPayment'],
                'label' => $arrPaymentSuccess['label'],
            ]
        );
    }

    public function detail($trans_id, Request $request): JsonResponse
    {
        $transactionData = $this->transactionHistoryService->findTransactionById($trans_id);
        return response()->json($transactionData);
    }

    public function delete($trans_id, Request $request): JsonResponse
    {
        try {
            $transactionData = $this->transactionHistoryService->deleteTransactionById($trans_id, $request->status);
            return response()->json($transactionData);
        } catch (Exception $e) {
            return response()->json(['error' => false, 'message' => $e->getMessage()]);
        }
    }

    public function callbackPayment(Request $request)
    {
        // Process save data
        try {
            $result = $this->transactionHistoryService->updateDataWhenCallback($request);
            if ($request->result and $result['status']) {
                $payment_success = $this->transactionHistoryService->findTransactionByOrderCode($request->order_code);
                $this->paymentSuccessService->createDataWhenCallback($payment_success);
                return response()->json(["status" => true]);
            }
            return response()->json([
                "status" => false,
                "messages" => $result['messages']
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}