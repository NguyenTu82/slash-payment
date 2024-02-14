<?php
declare(strict_types=1);

namespace App\Http\Controllers\Merchant;

use App\Enums\MerchantStoreStatus;
use App\Enums\MerchantUserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\Auth\ForgotPwSendMailRequest;
use App\Http\Requests\Merchant\Auth\LoginRequest;
use App\Http\Requests\Merchant\Auth\ResetPasswordRequest;
use App\Services\Merchant\AuthService;
use App\Services\Merchant\MerchantService;
use App\Services\Merchant\MerchantStoreService;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    protected AuthService $authService;

    protected MerchantService $merchantService;

    protected MerchantStoreService $merchantStoreService;

    /**
     * @param AuthService $authService
     * @param MerchantService $merchantService
     * @param MerchantStoreService $merchantStoreService
     */
    public function __construct(
        AuthService $authService,
        MerchantService $merchantService,
        MerchantStoreService $merchantStoreService
    ) {
        $this->authService = $authService;
        $this->merchantService = $merchantService;
        $this->merchantStoreService = $merchantStoreService;
    }

    public function login(): View|RedirectResponse
    {
        $merchantUser = auth('merchant')->user();

        if ($merchantUser) // ログインしてるならダッシュボードに遷移
            return redirect()->route('merchant.dashboard.index.get');

        return view('merchant.auth.login');
    }

    public function loginProcess(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $credentials['deleted_at'] = null;
        $remember = (bool) $request->remember;
        $response = $this->authService->loginAccount($credentials, $remember);

        if ($response['status']) {
            $merchant_user = auth('merchant')->user();
            // ログインアカウント状態確認
            if ($merchant_user->status == MerchantUserStatus::INVALID->value) {
                auth('merchant')->logout();
                return redirect()->back()->with('error', __('auth.common.login.invalid_email_merchant'))->withInput();
            }

            $merchantIsActive = $merchant_user->merchantStores()->pluck('status')
                ->contains(MerchantStoreStatus::IN_USE->value);

            // 加盟店状態確認
            if (!$merchantIsActive) {
                auth('merchant')->logout();
                return redirect()->back()->with('error', __('common.error.no_active_merchant'))->withInput();
            }

            session()->put('merchant_user', ['merchant_user' => $merchant_user,]);
            $merchant_role = $this->merchantStoreService->getRole($merchant_user->merchant_role_id);

            session()->put("merchant_roles", [
                "role_name" => object_get($merchant_role, "name"),
                "role_name_jp" => object_get($merchant_role, "name_jp"),
                "role_id" => object_get($merchant_role, "id"),
            ]);

            return redirect()->route('merchant.dashboard.index.get');
        }

        return redirect()->back()->withInput()->with([
            $response["type"] => $response["messages"],
            "email" => $request->email,
            "password" => $request->password,
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        auth('merchant')->logout();
        $request->session()->flush();

        return redirect()->route('merchant.auth.login');
    }

    public function forgotPassword(): View
    {
        return view('merchant.auth.forgot_password');
    }

    public function forgotPwConfirm(): View
    {
        return view('merchant.auth.forgot_password_confirm');
    }

    public function forgotPwSendMail(ForgotPwSendMailRequest $request): RedirectResponse
    {
        $email = $request->get('email');
        $data = [
            'email' => $email,
            'status' => MerchantUserStatus::VALID->value,
            'deleted_at' => null,
        ];
        $user = $this->merchantService->findUserValid($data)->first();

        if (empty($user)) {
            return redirect()->back()->with('error', __('common.error.not_exists_email'));
        }

        $response = $this->authService->forgotPwSendMail($email);

        if ($response) {
            return redirect()->route('merchant.auth.forgot_pw_confirm')
                ->with(['success' => 'send email successful']);
        }

        return redirect()->back()->with('error', false);
    }

    public function forgotPwChange(Request $request)
    {
        $checkToken = $this->authService->checkToken($request);
        if ($checkToken["status"]) {
            return view('merchant.auth.change_password', [
                'email' => $request->email,
                'token' => $request->token,
                'status' => 'not_done',
            ]);
        }
        return redirect()->route('merchant.auth.login')->with('error', $checkToken["message"]);
    }

    public function resetPassword(ResetPasswordRequest $request): View|RedirectResponse
    {
        $data = $request->only(['email', 'password', 'token']);
        $response = $this->authService->resetPassword($data);

        if ($response['status']) {
            return view('merchant.auth.change_password', [
                'status' => 'done',
            ]);
        }

        return redirect()->back()->withInput()->with('error', $response['message']);
    }

    public function registerIndex(Request $request)
    {
        return view('merchant.auth.register.index');
    }

    public function registerProcess(Request $request)
    {
        try {
            $result = $this->authService->registerAccount($request);
            if ($result) {
                return redirect()->route('merchant.auth.register.confirm.get');
            }

            return redirect()->back()->with('error', false)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function registerConfirm(Request $request)
    {
        return view('merchant.auth.register.register_confirm');
    }
}