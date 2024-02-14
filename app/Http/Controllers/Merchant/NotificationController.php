<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Services\Merchant\MerchantNotificationService;
use App\Services\Merchant\MerchantStoreService;
use App\Services\Merchant\AccountService;
use App\Enums\MerchantNotiStatus;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class NotificationController extends Controller
{
    private MerchantNotificationService $merchantNotificationService;
    private MerchantStoreService $merchantStoreService;
    private AccountService $accountService;
    public function __construct(
        MerchantNotificationService $merchantNotificationService,
        MerchantStoreService $merchantStoreService,
        AccountService $accountService
    )
    {
        $this->merchantNotificationService = $merchantNotificationService;
        $this->merchantStoreService = $merchantStoreService;
        $this->accountService = $accountService;
    }

    public function index(Request $request): View
    {
        $queryParams = (object) $request->query();
        $merchants = $this->accountService->findMerchantStoreOfUserLogin();
        $notifications = $this->merchantNotificationService->getNotiByMerchantId($queryParams)
            ->paginate($request->per_page ?? config('const.LIMIT_PAGINATION'));
        $notifications->appends($request->toArray());

        return view('merchant.notification.index', compact('notifications', 'request','merchants'));
    }

    public function detail($id): View
    {
        $noti = $this->merchantNotificationService->getNotiDetail($id);
        $merchant = $this->merchantStoreService->getMerchantStoreById($noti->merchant_id);

        if($noti->status == MerchantNotiStatus::UNREAD->value) {
            $this->merchantNotificationService->updateNotiStatusWhenOpen($id);
        }

        return view('merchant.notification.detail', compact('noti','merchant'));
    }

    public function delete($id)
    {
        $status = $this->merchantNotificationService->deleteNotiById($id);
        if ($status)
            return redirect()->route('merchant.notification.index.get')->with('success', 'delete_merchant_notification_success');
    }
}
