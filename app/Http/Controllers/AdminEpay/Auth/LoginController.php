<?php
declare(strict_types = 1);

namespace App\Http\Controllers\AdminEpay\Auth;

use App\Form\AdminCustomValidator;
use App\Http\Controllers\Controller;
use App\Services\LoginService;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Enums\AdminAccountStatus;

class LoginController extends Controller
{
    private LoginService $login;
    private AdminCustomValidator $form;
    private AdminService $adminService;

    public function __construct(
        LoginService $login,
        AdminCustomValidator $form,
        AdminService $adminService,
    ){
        $this->login = $login;
        $this->form = $form;
        $this->adminService = $adminService;
    }

    public function login(Request $request): View|RedirectResponse
    {
        if ($request->isMethod('post')) {
            // Validate inputs
            $this->form->validate($request, 'AdminLoginForm');
            $response = $this->login->loginAccount($request);
            
            if ($response["status"]) {
                //Check user verify
                $user = auth("epay")->user();
                if ($user->status == AdminAccountStatus::INVALID->value) {
                    auth('epay')->logout();
                    return redirect()->back()->with('error', __('auth.common.login.invalid_email'));
                }
                $roleDefault = $this->adminService->getRoleByAdmin($user->role_id);
                $roleName = object_get($roleDefault, "name");
                session()->put("admin_roles", [
                    "role_name" => $roleName,
                    "role_name_jp" => object_get($roleDefault, "name_jp"),
                    "role_id" => object_get($roleDefault, "id"),
                ]);

                return redirect()->route('admin_epay.dashboard.index.get');
            }

            return redirect()->back()->withInput()->with([
                $response["type"] => $response["messages"],
                "email" => $request->email,
                "password" => $request->password,
            ]);
        }

        $adminUser = auth('epay')->user();

        if ($adminUser) // ログインしてるならダッシュボードに遷移
            return redirect()->route('admin_epay.dashboard.index.get');

        return view('epay.auth.login');
    }

    public function logout(Request $request): RedirectResponse
    {
        Cache::forget(session("admin_roles.role_id"));
        auth('epay')->logout();
        $request->session()->flush();

        return redirect()->route('admin_epay.auth.login');
    }
}
