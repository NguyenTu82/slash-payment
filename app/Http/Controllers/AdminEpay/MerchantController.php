<?php

namespace App\Http\Controllers\AdminEpay;

use App\Exports\MerchantStoreExport;
use App\Exports\TransactionHistoryExport;
use App\Form\AdminCustomValidator;
use App\Http\Controllers\Controller;
use App\Services\BalanceService;
use App\Services\Merchant\MerchantStoreService;
use App\Services\Merchant\PaymentSuccessService;
use App\Services\Merchant\TransactionHistoryService;
use App\Services\SlashWeb3Api\SlashWeb3ApiService;
use Exception;
use Illuminate\Http\Request;

/**
 * Class MerchantController.
 *
 * @package namespace App\Http\Controllers\AdminEpay;
 */
class MerchantController extends Controller
{
    protected MerchantStoreService $merchantStoreService;

    protected TransactionHistoryService $transactionHistoryService;

    protected PaymentSuccessService $paymentSuccessService;

    protected BalanceService $balanceService;

    protected AdminCustomValidator $form;

    protected SlashWeb3ApiService $slashWeb3PaymentService;

    public function __construct(
        MerchantStoreService $merchantStoreService,
        TransactionHistoryService $transactionHistoryService,
        PaymentSuccessService $paymentSuccessService,
        BalanceService $balanceService,
        AdminCustomValidator $form,
        SlashWeb3ApiService $slashWeb3PaymentService,
    ) {
        $this->merchantStoreService = $merchantStoreService;
        $this->transactionHistoryService = $transactionHistoryService;
        $this->paymentSuccessService = $paymentSuccessService;
        $this->balanceService = $balanceService;
        $this->form = $form;
        $this->slashWeb3PaymentService = $slashWeb3PaymentService;
    }

    public function index(Request $request)
    {
        $queryParams = (object) $request->query();
        $response = $this->merchantStoreService->getMerchantStores($queryParams);
        $data_csv = $response->get();
        $stores = $response->paginate($request->per_page ?? config('const.LIMIT_PAGINATION'));
        $stores->appends($request->toArray());

        if ($request->has('csv')) {
            if ($queryParams->csv) {
                $export = new MerchantStoreExport($data_csv);

                return $export->download('merchant_stores_' . date('YmdHis') . '.csv')
                    ->deleteFileAfterSend(true);
            }
        }

        return view('epay.merchantStore.index', compact('stores', 'request'));
    }

    public function detailMerchantStore(Request $request, $id)
    {
        $dataMerchant = $this->merchantStoreService->findDataMerchantById($request->id);

        if ($request->wantsJson()) {
            $html = view('merchant.setting.modal.partial.content_detail_store', compact(
                'dataMerchant',
            )
            )->render();

            return response()->json([
                'message' => 'Getting successful',
                'data' => $html,
                'merchant' => formatAccountId($dataMerchant->merchant_code).' - '.$dataMerchant->name,
            ]);
        }

        return view('epay.merchantStore.detail', [
            'activeMenu' => 'merchant',
            'dataMerchant' => $dataMerchant,
        ]);
    }

    public function createMerchantStore(Request $request)
    {
        try {
            // Process save data
            $response = $this->merchantStoreService->createMerchantStore($request);
            if ($response['status'] === true) {
                return redirect()->route('admin_epay.merchantStore.index.get')->with('success', 'create_merchant_success');
            }

            return redirect()->back()->with([
                'error' => $response['messages'],
                'sending_detail_error' => '',
                'guidance_email_error' => '',
                'afSwitch_error' => '',
                'old_group' => json_decode($request['group']),
                'old_group_id' => json_decode($request['group_id'])
            ])->withInput();
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function viewCreateMerchantStore()
    {
        $merchantStores = $this->merchantStoreService->getAllMerchantStoresNotParent();

        return view('epay.merchantStore.add', [
            'activeMenu' => 'merchant',
            'merchantStores' => $merchantStores,
        ]);
    }

    public function checkPostalCode(Request $request)
    {
        $status = $this->merchantStoreService->checkPostalCode($request->postal_code);

        return response()->json($status);
    }

    public function updateMerchantStore(Request $request, $id)
    {
        try {
            // Process save data
            $response = $this->merchantStoreService->updateMerchantStore($request, $id);
            if ($response['status'] === true) {
                return redirect()->route('admin_epay.merchantStore.detail', $id)->with('success', 'update_merchant_success');
            }

            return redirect()->back()->with('error', $response['messages'])->withInput();
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function viewEditMerchantStore(Request $request)
    {
        $dataMerchant = $this->merchantStoreService->findDatamerchantByid($request->id);
        $merchantStores = count($dataMerchant->parent) > 0 ? [] : $this->merchantStoreService->getAllMerchantStoresNotParentWithoutId($request->id);
        $groups = count($dataMerchant->parent) > 0 ? [] : $dataMerchant->groups->pluck("id")->toArray();

        return view('epay.merchantStore.edit', [
            'activeMenu' => 'merchant',
            'dataMerchant' => $dataMerchant,
            'merchantStores' => $merchantStores,
            'groups' => $groups,
        ]);
    }

    public function usageSituationIndex($id, Request $request)
    {
        $queryParams = (object) $request->query();
        $queryParams->merchant_store_id = $id;
        $queryParams->startAmount = isset($queryParams->startAmount) ? str_replace(',','',$queryParams->startAmount) : null;
        $queryParams->endAmount = isset($queryParams->endAmount) ? str_replace(',','',$queryParams->endAmount) : null;

        // query data for card and graph
        $arrPaymentSuccess = $this->paymentSuccessService->getQueryPaymentSuccessByType($queryParams);

        // query data for table
        $arrTrans = $this->transactionHistoryService->findTransactionHistories($queryParams, $request);

        // download csv
        if ($request->has('csv')) {
            $export = new TransactionHistoryExport($arrTrans['data_csv']);

            return $export->download('usage_situation_' . date('YmdHis') . '.csv')
                ->deleteFileAfterSend(true);
        }

        return view(
            'epay.usage_situation.index',
            [
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

    public function deleteMerchantStore(Request $request, $id)
    {
        try {
            // Process save data
            $response = $this->merchantStoreService->deleteMerchantStore($id);
            if ($response === true) {
                return redirect()->route('admin_epay.merchantStore.index.get')->with('success', 'delete_merchant_success');
            }

            return redirect()->back()->with('error', $response);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function checkGroup(Request $request)
    {
        $status = $this->merchantStoreService->checkGroup($request->merchant_id);

        return response()->json($status);
    }

    public function usageSituationDetail($id, $trans_id, Request $request)
    {
        $transactionData = $this->transactionHistoryService->findTransactionById($trans_id);

        return response()->json($transactionData);
    }

    public function usageSituationDelete($id, $trans_id, Request $request)
    {
        try {
            $transactionData = $this->transactionHistoryService->deleteTransactionById($trans_id, $request->status);

            return response()->json($transactionData);
        } catch (Exception $e) {
            return response()->json(['error' => false, 'message' => $e->getMessage()]);
        }
    }

    public function usageSituationUpdate($id, $trans_id, Request $request)
    {
        try {
            $transactionData = $this->transactionHistoryService->upateTransactionById($id, $trans_id, $request);

            return response()->json($transactionData);
        } catch (Exception $e) {
            return response()->json(['error' => false, 'message' => $e->getMessage()]);
        }
    }

    public function verifyRegisterMerchant($id, $token)
    {
        try {
            // Process save data
            $response = $this->merchantStoreService->verifyRegisterMerchant($id, $token);
            if ($response['status'] === true) {
                auth('merchant')->logout();

                return view(
                    'epay.merchantStore.verify_register_success',
                );
            }

            return redirect()->route('merchant.auth.login')->with('error', $response['messages']);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function changePass(Request $request)
    {
        try {
            $this->form->validate(
                $request,
                'ChangPasswordForm'
            );
            // Process save data
            $response = $this->merchantStoreService->changePass($request);

            return response()->json($response);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getBalanceSummary(Request $request, $merchantStoreId)
    {
        $balanceSummary = $this->balanceService->getBalanceSummary($merchantStoreId);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Getting successful',
                'data' => $balanceSummary,
            ]);
        }

        return false;
    }

    public function getPaymentIndex(Request $request)
    {
        return view('merchant.payment.index');
    }

    public function createQRForPayment(Request $request)
    {
        try {
            $response = $this->slashWeb3PaymentService->createQRForPayment($request->amount);
            if ($response->hasError()) {
                return redirect()->back()->with('error', $response->getErrorReason());
            }
            return $response->getResult();
        } catch (Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
                ], $e->getCode());
            }

            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}