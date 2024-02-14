<?php

namespace App\Http\Controllers\Merchant;

use App\Exports\WithdrawHistoryExport;
use App\Form\Merchant\BaseValidatorCustom;
use App\Http\Controllers\Controller;
use App\Services\Merchant\AccountService;
use App\Services\Merchant\MerchantService;
use App\Services\Merchant\MerchantStoreService;
use App\Services\Merchant\WithdrawService;
use App\Services\WithdrawLimitService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class WithdrawController extends Controller
{
    private WithdrawService $withdrawService;

    private AccountService $accountService;

    protected MerchantStoreService $merchantStoreService;

    private MerchantService $merchantService;

    private BaseValidatorCustom $form;

    private WithdrawLimitService $withdrawLimitService;

    public function __construct(
        WithdrawService $withdrawService,
        AccountService $accountService,
        MerchantStoreService $merchantStoreService,
        MerchantService $merchantService,
        BaseValidatorCustom $form,
        WithdrawLimitService $withdrawLimitService
    ) {
        $this->withdrawService = $withdrawService;
        $this->accountService = $accountService;
        $this->merchantStoreService = $merchantStoreService;
        $this->merchantService = $merchantService;
        $this->form = $form;
        $this->withdrawLimitService = $withdrawLimitService;
    }

    public function getHistories(Request $request): View|Response|BinaryFileResponse
    {
        $filter = (object) [
            'merchant_user_id' => $request->merchant_user_id ?? auth('merchant')->user()->id,
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
            'sort_by' => $request->sort_by ?? 'created_at',
            'sort_direction' => $request->sort_direction ?? 'desc',
        ];

        $roles = $this->accountService->getRoles();
        $baseHistories = $this->withdrawService->getHistories($filter);

        if ($request->export_csv) {
            $export = new WithdrawHistoryExport($baseHistories->get());

            return $export->download('epay_withdraw_histories_' . date('YmdHis') . '.csv')
                ->deleteFileAfterSend(true);
        }

        $histories = $baseHistories->paginate($request->per_page ?? config('const.LIMIT_PAGINATION'));
        $histories->appends($request->toArray());

        return view('merchant.withdraw.history.index', compact(
            'roles',
            'histories',
            'request'
        ));
    }

    public function getWithdrawHistory($id): View
    {
        $withdrawLimits = json_encode($this->withdrawLimitService->getWithdrawLimitList());
        $withdraw = $this->withdrawService->getWithdrawHistory($id);
        $storesAssigned = $this->merchantService->getStoresAssigned();

        return view('merchant.withdraw.history.detail', compact(
            'withdraw',
            'storesAssigned',
            'withdrawLimits'
        ));
    }

    public function createRequestWithdraw(Request $request): View
    {
        $storesAssigned = $this->merchantService->getStoresAssigned();
        $withdrawLimits = $this->withdrawLimitService->getWithdrawLimitList();
        $withdrawLimits = json_encode($withdrawLimits);

        return view('merchant.withdraw.request.create', compact(
            'request',
            'storesAssigned',
            'withdrawLimits'
        ));
    }

    public function storeRequestWithdraw(Request $request)
    {
        try {
            $this->form->validate(
                $request,
                'CreateWithdrawRequestForm'
            );
            $this->withdrawService->createRequestWithdraw($request);

            if ($request->wantsJson()) {
                Session::flash('success', 'merchant_create_request_withdraw_success');

                return response()->json([
                    "status" => true,
                    'message' => 'Create successful',
                ]);
            }

            return redirect()->route('merchant.withdraw.history.index.get')
                ->with('success', 'merchant_create_request_withdraw_success');
        } catch (Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                ]);
            }

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateWithdrawHistory(Request $request, $id)
    {
        try {
            $this->withdrawService->updateWithdrawHistory($request, $id);

            return redirect()->route('merchant.withdraw.history.detail.get', $id)
                ->with('success', 'merchant_update_withdraw_success');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleteWithdrawHistory(Request $request, $id)
    {
        try {
            $this->withdrawService->deleteWithdrawHistory($request, $id);

            return redirect()->route('merchant.withdraw.history.index.get')
                ->with('success', 'merchant_delete_withdraw_success');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getFiatAccountDefault(Request $request, $merchantStoreId)
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

    public function getCryptoAccountDefault(Request $request, $merchantStoreId)
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
