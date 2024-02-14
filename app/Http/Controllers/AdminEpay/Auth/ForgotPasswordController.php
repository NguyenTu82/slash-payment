<?php

namespace App\Http\Controllers\AdminEpay\Auth;

use App\Form\AdminCustomValidator;
use App\Http\Controllers\Controller;
use App\Models\DtbUserTokens;
use App\Rules\ExtendedPassword;
use App\Services\AdminService;
use App\Services\LoginService;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{

    protected LoginService $login;

    protected AdminCustomValidator $form;

    protected AdminService $adminService;
    /**
     * __construct
     *
     * @param LoginService $login
     * @param AdminCustomValidator $form
     *
     * @return void
     */
    public function __construct(
        LoginService $login,
        AdminCustomValidator $form,
        AdminService $adminService
    ) {
        $this->login = $login;
        $this->form = $form;
        $this->adminService = $adminService;
    }

    /**
     * Resend Verify Email Register user
     *
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword(Request $request)
    {
        if ($request->isMethod("post")) {
            // Validate inputs
            $this->form->validate($request, "ConfirmEmailForm");
            $response = $this->login->confirmEmail($request);
            if ($response === true) {
                return redirect()
                    ->route('admin_epay.auth.forgot_password_confirm')
                    ->with(["success" => __("admin_epay.messages.send_email_successful")]);
            }
            return redirect()
                ->back()
                ->with("error", $response);
        }
        return view("epay.auth.forgot_password");
    }

    public function forgotPasswordConfirm(Request $request)
    {
        return view("epay.auth.forgot_password_confirm");
    }

    /**
     * Change password
     *
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function change_password(Request $request)
    {
        $user = auth("epay")->user();
        if (!empty($user)) {
            auth('epay')->logout();
            $request->session()->flush();
        }
        if ($request->isMethod("post")) {
            // Validate inputs
            $this->form->validate($request, "AdminChangePasswordForm");

            $response = $this->adminService->resetPassword($request);
            if ($response["status"] === true) {
                return view("epay.auth.change_password",[
                    "status" => "done",
                ]);
            }
            return redirect()
                ->back()
                ->withInput()
                ->with("error", $response["message"]);
        }
        // $response = $this->adminService->verify($request);
        // if ($response["status"] === false) {
        //     return redirect()
        //         ->route("login")
        //         ->withInput()
        //         ->with("error", $response["message"] ?? "");
        // }
        $checkToken = $this->adminService->checkToken($request);
        if ($checkToken["status"])
        {
            return view("epay.auth.change_password", [
                "email" => $request->email,
                "token" => $request->token,
                "status" => "not_done",
                // "admin" => $response["data"] ?? "",
            ]);
        }
        return redirect()->route('admin_epay.auth.login')->with('error',$checkToken["message"]);
    }
}
