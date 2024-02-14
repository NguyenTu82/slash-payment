<?php

namespace App\Http\Controllers\AdminEpay;

use App\Enums\AdminRole;
use App\Form\AdminCustomValidator;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminEpay\CreateAdminRequest;
use App\Services\AdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    private AdminCustomValidator $form;

    private AdminService $adminService;

    public function __construct(AdminCustomValidator $form, AdminService $adminService)
    {
        $this->form = $form;
        $this->adminService = $adminService;
    }

    public function getProfile(Request $request): View
    {
        $roles = $this->adminService->getRoles();
        $activeMenu = ['setting','profile'];

        return view('epay.setting.profile', compact(
            'roles',
            'activeMenu',
        ));
    }

    public function changePass(Request $request): JsonResponse
    {
        $this->form->validate(
            $request,
            'ChangPasswordForm'
        );

        return $this->adminService->changePassword($request);
    }

    public function updateProfile(Request $request): array
    {
        $this->form->validate(
            $request,
            'UpdateProfileForm'
        );
        $data = $request->only('name', 'email', 'role_id', 'note');

        return $this->adminService->updateProfile($data);
    }

    public function index(Request $request): View
    {
        $queryParams = (object) $request->query();
        $roles = $this->adminService->getRoles();
        $dataUsers = $this->adminService->getAccounts($queryParams)
            ->paginate($request->per_page ?? config('const.LIMIT_PAGINATION'));
        $dataUsers->appends($request->toArray());

        return view('epay.admin.index', compact('roles', 'dataUsers', 'request'));
    }

    public function create(): View|RedirectResponse
    {
        if(auth('epay')->user()->role->name == AdminRole::OPERATOR->value) {
            return redirect()->back();
        }

        $roles = $this->adminService->getRoles();

        return view('epay.admin.create', compact('roles'));
    }

    public function store(CreateAdminRequest $request): RedirectResponse
    {
        $this->adminService->saveDataAdmin($request);

        return redirect()->route('admin_epay.account.index.get')->with('success', 'create_merchant_user_success');
    }
}
