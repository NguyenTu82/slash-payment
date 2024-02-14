<?php

namespace App\Services;

use App\Enums\AdminAccountStatus;
use App\Jobs\SendEmailJob;
use App\Mail\ForgotPasswordMail;
use App\Repositories\AdminRepositoryInterface;
use App\Repositories\AdminTokenRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LoginService
{
    private AdminRepositoryInterface $adminRepository;

    private AdminTokenRepositoryInterface $adminTokenRepository;

    public function __construct(
        AdminRepositoryInterface $adminRepository,
        AdminTokenRepositoryInterface $adminTokenRepository
    ) {
        $this->adminRepository = $adminRepository;
        $this->adminTokenRepository = $adminTokenRepository;
    }

    public function loginAccount($request)
    {
        $input = $request->only('email', 'password');
        $input['deleted_at'] = null;

        if (count($this->adminRepository->findOneBy(["email" => $request->email])) == 0){
            return [
                "status" => false,
                "type" => "email-error",
                "messages" => __('auth.common.login.email_not_correct')
            ];
        }

        // set the remember me cookie if the user check the box
        $remember = (bool) $request->remember;
        if (!auth("epay")->attempt($input, $remember)) {
            return [
                "status" => false,
                "type" => "password-error",
                "messages" => __('auth.common.login.not_correct')
            ];
        }

        return ["status" => true];
    }

    public function confirmEmail($request)
    {
        // Check info login
        $user = $this->adminRepository->getuserForgotPass($request->email);
        if (empty($user)) {
            return __("common.error.not_exists_email");
        }
        $token = Str::random(255);
        try {
            $url = route('admin_epay.auth.change_password')."?token=$token" . "&email=$request->email";
            $mailInfo = [
                "email" => $request->email,
                "url_change_password" => $url,
            ];
            $dataAdminArr = [
                "token" => $token,
                "valid_at" => Carbon::now()->addHours(
                    config("const.EMAIL_VALID_DT")
                ),
            ];
            // Create table Admin
            $adminToken = $this->adminTokenRepository->findOneBy(["email" => $user->email]);
            if (!empty($adminToken)){
                $this->adminTokenRepository->update($adminToken["id"], $dataAdminArr);
            } else {
                $this->adminTokenRepository->create([
                    "email" => $user->email,
                    "token" => $token,
                    "valid_at" => Carbon::now()->addHours(
                        config("const.EMAIL_VALID_DT")
                    ),
                ]);
            }
            SendEmailJob::dispatch(new ForgotPasswordMail($mailInfo), $user->email)->onQueue('emails');

            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return __('admin_epay.messages.error_has_occurred');
        }
    }
}
