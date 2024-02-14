<?php

namespace App\Http\Controllers\AdminEpay;

use App\Exports\WithdrawHistoryExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\CreateWithdrawRequest;
use App\Services\Epay\EpayWithdrawService;
use App\Services\Merchant\AccountService;
use App\Services\Merchant\MerchantStoreService;
use App\Services\Merchant\WithdrawService;
use App\Services\WithdrawLimitService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class EpayWithdrawController extends Controller
{
    private EpayWithdrawService $epayWithdrawService;

    protected AccountService $accountService;

    protected MerchantStoreService $merchantStoreService;

    private WithdrawService $withdrawService;

    private WithdrawLimitService $withdrawLimitService;

    public function __construct(
        AccountService $accountService,
        EpayWithdrawService $epayWithdrawService,
        MerchantStoreService $merchantStoreService,
        WithdrawService $withdrawService,
        WithdrawLimitService $withdrawLimitService
    ) {
        $this->epayWithdrawService = $epayWithdrawService;
        $this->accountService = $accountService;
        $this->merchantStoreService = $merchantStoreService;
        $this->withdrawService = $withdrawService;
        $this->withdrawLimitService = $withdrawLimitService;
    }

    public function getHistories(Request $request): View|Response|BinaryFileResponse
    {
        $filter = (object) [
            'merchant_id' => $request->merchant_id ?? auth('epay')->user()->id,
            'transaction_id' => $request->transaction_id ?? '',
            'order_id' => $request->order_id ?? '',
            'merchant_store_id' => $request->merchant_store_id ?? '',
            'merchant_store_name' => $request->merchant_store_name ?? '',
            'request_date_from' => $request->request_date_from ? formatDateSimple($request->request_date_from) : '',
            'request_date_to' => $request->request_date_to ? formatDateSimple($request->request_date_to) : '',
            'approve_time_from' => $request->approve_time_from ? formatDateSimple($request->approve_time_from) : '',
            'approve_time_to' => $request->approve_time_to ? formatDateSimple($request->approve_time_to) : '',
            'withdraw_request_method' => $request->withdraw_request_method ?? '',
            'withdraw_method' => $request->withdraw_method ?? '',
            'withdraw_status' => $request->withdraw_status ?? '',
            'asset' => $request->asset ?? '',
            'amount_from' => is_numeric($request->amount_from) ? $request->amount_from : null,
            'amount_to' => is_numeric($request->amount_to) ? $request->amount_to : null,
            'withdraw_name' => $request->withdraw_name ?? '',
            'page' => $request->page ?? 1,
            'per_page' => $request->per_page ?? config('const.LIMIT_PAGINATION'),
            'sort_by' => $request->sort_by ?? '',
            'sort_direction' => $request->sort_direction ?? '',
        ];

        $baseHistories = $this->epayWithdrawService->getHistories($filter);

        if ($request->export_csv) {
            $export = new WithdrawHistoryExport($baseHistories->get());

            return $export->download('withdraw_histories_' . date('YmdHis') . '.csv')
                ->deleteFileAfterSend(true);
        }

        $histories = $baseHistories->paginate($request->per_page ?? config('const.LIMIT_PAGINATION'));
        $histories->appends($request->toArray());

        return view('epay.withdraw.history.index', compact('histories', 'request'));
    }

    public function detail($id): View
    {
        $withdrawLimits = $this->withdrawLimitService->getWithdrawLimitList();
        $withdraw = $this->epayWithdrawService->getWithdrawHistory($id);

        return view('epay.withdraw.history.detail', compact('withdraw', 'withdrawLimits'));
    }

    public function edit($id): View
    {
        $withdrawLimits = $this->withdrawLimitService->getWithdrawLimitList();
        $withdraw = $this->epayWithdrawService->getWithdrawHistory($id);

        return view('epay.withdraw.history.edit', ['withdraw' => $withdraw, 'withdrawLimits' => json_encode($withdrawLimits)]);
    }

    public function editWithdraw(Request $request, $id): RedirectResponse
    {
        try {
            // Process save data
            $response = $this->epayWithdrawService->updateWithdraw($request, $id);
            if ($response) {
                return redirect()->route('admin_epay.withdraw.history.detail.get', $id)->with('success', 'update_withdraw_success');
            }

            return redirect()->back()->with('error', __('merchant.withdraw.over_amount'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function approve($id): RedirectResponse
    {
        try {
            // Process save data
            $response = $this->epayWithdrawService->approve($id);
            if ($response['status']) {
                return redirect()->route('admin_epay.withdraw.history.detail.get', $id)
                    ->with('success', $response['type']);
            }

            return redirect()->back()->with('error', $response['message']);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function decline($id): RedirectResponse
    {
        try {
            $this->epayWithdrawService->decline($id);

            return redirect()->route('admin_epay.withdraw.history.detail.get', $id)
                ->with('success', 'withdraw_decline_success');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleteWithdraw($id)
    {
        try {
            // Process save data
            $this->epayWithdrawService->deleteWithdraw($id);

            return redirect()->route('admin_epay.withdraw.history.index.get')->with('success', 'delete_withdraw_success');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function create(Request $request): View
    {
        $allMerchantStores = $this->merchantStoreService->getAllMerchantStores();
        $withdrawLimits = $this->withdrawLimitService->getWithdrawLimitList();
        $withdrawLimits = json_encode($withdrawLimits);

        return view('epay.withdraw.request.create', compact(
            'request',
            'allMerchantStores',
            'withdrawLimits'
        ));
    }

    public function store(CreateWithdrawRequest $request)
    {
        try {
            $this->withdrawService->createRequestWithdraw($request);

            if ($request->wantsJson()) {
                Session::flash('success', 'merchant_create_request_withdraw_success');

                return response()->json([
                    "status" => true,
                    'message' => 'Create successful',
                ]);
            }

            return redirect()->route('admin_epay.withdraw.history.index.get')
                ->with('success', 'merchant_create_request_withdraw_success');
        } catch (Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                ]);
            }

            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function getFiatAccountDefault(Request $request, $merchantStoreId): bool|\Illuminate\Http\JsonResponse
    {
        $fiatAccount = $this->withdrawService->getFiatAccountDefault($merchantStoreId);
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Getting successful',
                'data' => $fiatAccount,
            ]);
        }

        return false;
    }

    public function getCryptoAccountDefault(Request $request, $merchantStoreId): bool|\Illuminate\Http\JsonResponse
    {
        $cryptoAccount = $this->withdrawService->getCryptoAccountDefault($merchantStoreId);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Getting successful',
                'data' => $cryptoAccount,
            ]);
        }

        return false;
    }
}
