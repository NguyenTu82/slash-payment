<?php

namespace App\Http\Controllers\AdminEpay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AccountService;
use App\Services\AdminService;
use App\Form\AdminCustomValidator;

use Exception;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class AccountController.
 *
 * @package namespace App\Http\Controllers\AdminEpay;
 */
class AccountController extends Controller
{
    protected AccountService $accountService;
    protected AdminService $adminService;
    private AdminCustomValidator $form;


    public function __construct(
        AccountService $accountService,
        AdminService $adminService,
        AdminCustomValidator $form,

    ) {
        $this->accountService = $accountService;
        $this->adminService = $adminService;
        $this->form = $form;
    }

    public function detail($id): View
    {
        $admin = $this->adminService->getAdminById($id);
        $roles = $this->adminService->getRoles();

        return view("epay.admin.detail", [
            "adminUser" => $admin,
            "dataRoles" => $roles,
        ]);
    }

    public function changePassword(Request $request): JsonResponse
    {
        $this->form->validate($request, 'ChangPasswordForm');

        return $this->accountService->changePassword($request);
    }

    public function removeAccount(Request $request): RedirectResponse
    {
        try {
            $this->accountService->deleteAccount($request);

            return redirect()->route('admin_epay.account.index.get')
                ->with('deleteSuccess', 'Delete Account Success');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateProfile(Request $request, $id): array
    {
        $this->form->validate(
            $request,
            'UpdateProfileUserForm'
        );
        $data = $request->only('email', 'name', 'role_id', 'note', 'status');
        return $this->accountService->updateProfile($data, $id);
    }
}
