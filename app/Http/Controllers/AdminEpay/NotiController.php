<?php

namespace App\Http\Controllers\AdminEpay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Epay\NotificationService;
use App\Services\Merchant\MerchantService;
use App\Services\Merchant\MerchantStoreService;
use Illuminate\Contracts\View\View;
use App\Enums\NotiStatusReceive;
use App\Form\AdminCustomValidator;
use Illuminate\Http\RedirectResponse;
use Exception;

class NotiController extends Controller
{
    private NotificationService $notificationService;
    private AdminCustomValidator $form;
    protected MerchantService $merchantService;
    private MerchantStoreService $merchantStoreService;

    public function __construct(
        NotificationService $notificationService,
        AdminCustomValidator $form,
        MerchantService $merchantService,
        MerchantStoreService $merchantStoreService,
    ) {
        $this->notificationService = $notificationService;
        $this->form = $form;
        $this->merchantService = $merchantService;
        $this->merchantStoreService = $merchantStoreService;
    }

    public function index(Request $request): View
    {
        $queryParams = (object) $request->query();

        if ($request->select_type == \App\Enums\NotiSelectedType::RECEIVE->value || $request->select_type == null)
            $dataList = $this->notificationService->listReceive($queryParams);
        else
            $dataList = $this->notificationService->listSend($queryParams);

        $dataList = $dataList->paginate($request->per_page ?? config('const.LIMIT_PAGINATION'));
        $dataList->appends($request->toArray());

        return view('epay.notification.index', compact('dataList', 'request'));
    }

    public function receiveDetail($id): View
    {
        $notificationReceived = $this->notificationService->getReceivedNotiDetail($id);

        if ($notificationReceived->status == NotiStatusReceive::UNREAD->value) {
            $this->notificationService->updateNotiStatusWhenOpen($id);
        }

        return view('epay.notification.receive_detail', compact('notificationReceived'));
    }

    public function viewTemplate(): View
    {
        $notifications = $this->notificationService->getAllNotiTemplate();
        return view('epay.notification.update', compact('notifications'));
    }

    public function updateTemplate(Request $request, $id): array
    {
        $this->form->validate($request, 'UpdateNotiTemplateForm');
        $data = $request->only('title', 'content');

        return $this->notificationService->updateNotiTemplate($data, $id);
    }

    public function receiveDelete($id): RedirectResponse
    {
        $status = $this->notificationService->deleteReceivedNotiById($id);

        if ($status)
            return redirect()->route('admin_epay.notification.index.get')
                ->with('success', 'delete_merchant_notification_success');

        return redirect()->back();
    }

    public function createNotification(Request $request): View
    {
        $userInfo = auth('epay')->user();
        $allMerchantStores = $this->merchantStoreService->getAllMerchantStores();

        return view('epay.notification.create', compact('allMerchantStores', 'request', 'userInfo'));
    }

    public function storeSendNotification(Request $request): RedirectResponse
    {
        try {
            $dataRequest = (object)$request->all();
            $this->notificationService->createNotificationSendToMerchant($dataRequest);

            return redirect()->route('admin_epay.notification.index.get', ['select_type' => 1])
                ->with('success', 'create_notification_to_merchant_success');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function sendDetail($id): View
    {
        $notificationSend = $this->notificationService->getSendNotiDetail($id);

        return view('epay.notification.send_detail', compact('notificationSend'));
    }

    public function sendDelete($id): RedirectResponse
    {
        try {
            $status = $this->notificationService->deleteSendNotiById($id);
            if ($status)
                return redirect()->route('admin_epay.notification.index.get',["select_type" => 1])
                    ->with('success', 'delete_notification_to_merchant_success');
            return redirect()->back()->with('error',$status);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function editNotification(Request $request, $id): View
    {
        $notificationSend = $this->notificationService->getSendNotiDetail($id);
        $allMerchantStores = $this->merchantStoreService->getAllMerchantStores();

        return view('epay.notification.send_edit', compact('notificationSend','allMerchantStores'));
    }

    public function editSendNotification(Request $request,$id): RedirectResponse
    {
        try {
            $dataRequest = (object) $request->all();
            $status = $this->notificationService->editNotificationSendToMerchant($dataRequest, $id);
            if ($status) {
                return redirect()->route("admin_epay.notification.send_detail.get",$id)->with('success', 'update_notification_to_merchant_success');
            }
            return redirect()->back()->with('error', $status);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
