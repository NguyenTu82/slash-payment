<?php

namespace App\Services\Merchant;

use App\Jobs\Merchant\SendEmailResetPwJob;
use App\Repositories\MerchantUserRepository;
use App\Repositories\MerchantTokenRepository;
use App\Repositories\MerchantRoleRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use \App\Enums\MerchantUserStatus;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendEmailJob;
use App\Mail\CreateMerchantMail;
use App\Enums\MerchantStoreStatus;
use App\Repositories\MerchantStoreRepository;
use App\Repositories\GroupMerchantRepository;

class AuthService
{
    protected MerchantUserRepository $merchantUserRepository;

    protected MerchantTokenRepository $merchantTokenRepository;

    protected MerchantRoleRepository $merchantRoleRepository;

    protected MerchantStoreRepository $merchantStoreRepository;

    protected GroupMerchantRepository $groupMerchantRepository;

    /**
     * @param MerchantUserRepository $merchantUserRepository
     * @param MerchantTokenRepository $merchantTokenRepository
     * @param MerchantRoleRepository $merchantRoleRepository
     * @param MerchantStoreRepository $merchantStoreRepository
     */
    public function __construct(
        MerchantUserRepository $merchantUserRepository,
        MerchantTokenRepository $merchantTokenRepository,
        MerchantRoleRepository $merchantRoleRepository,
        MerchantStoreRepository $merchantStoreRepository,
        GroupMerchantRepository $groupMerchantRepository,
    ) {
        $this->merchantUserRepository = $merchantUserRepository;
        $this->merchantTokenRepository = $merchantTokenRepository;
        $this->merchantRoleRepository = $merchantRoleRepository;
        $this->merchantStoreRepository = $merchantStoreRepository;
        $this->groupMerchantRepository = $groupMerchantRepository;
    }

    public function loginAccount($credentials, $remember): array
    {
        $input = array_merge($credentials, ['deleted_at' => null]);
        // Set the remember me cookie if the user check the box
        if (count($this->merchantUserRepository->findByField("email", $credentials["email"])) == 0) {
            return [
                "status" => false,
                "type" => "email-error",
                "messages" => __('auth.common.login.email_not_correct')
            ];
        }
        // set the remember me cookie if the user check the box
        if (!auth("merchant")->attempt($input, $remember)) {
            return [
                "status" => false,
                "type" => "password-error",
                "messages" => __('auth.common.login.not_correct')
            ];
        }

        return ["status" => true];
    }

    public function forgotPwSendMail($email): bool
    {
        $token = Str::random(255);
        $dataMerchantToken = [
            'email' => $email,
            'token' => $token,
            "valid_at" => Carbon::now()->addHours(
                config("const.EMAIL_VALID_DT")
            ),
        ];
        $this->merchantTokenRepository->updateOrCreate(
            ['email' => $email],
            $dataMerchantToken
        );
        $url = route('merchant.auth.forgot_pw_change') . "?token=$token&email=$email";
        $dataSendMail = [
            'email' => $email,
            "url" => $url
        ];
        dispatch(new SendEmailResetPwJob($dataSendMail))->onQueue('emails');
        ;

        return true;
    }

    public function resetPassword($data): array|bool
    {
        DB::beginTransaction();
        try {
            $password = $data['password'] ?? '';
            $email = $data['email'] ?? '';
            $merchantToken = $this->merchantTokenRepository->findMerchantToken($data);
            if (!$merchantToken) {
                return [
                    "status" => false,
                    "message" => __("common.error.token_invalid"),
                ];
            }

            if (Carbon::parse($merchantToken->valid_at)->isPast()) {
                return [
                    "status" => false,
                    "message" => __("common.error.code_expired"),
                ];
            }

            $merchantUser = $this->merchantUserRepository->findUserByEmail($email);
            $dataUpdate['password'] = bcrypt($password);
            $this->merchantUserRepository->update($dataUpdate, $merchantUser->id);

            $merchantToken->delete();
            DB::commit();

            return [
                "status" => true,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
    public function checkToken($request)
    {
        $admin = $this->merchantTokenRepository->findByField("email", $request->email);
        if (count($admin) == 0) {
            return [
                "status" => false,
                "message" => __("common.error.token_expired"),
            ];
        }
        if ($admin[0]["token"] != $request->token) {
            return [
                "status" => false,
                "message" => __("common.error.token_invalid"),
            ];
        }
        $date1 = Carbon::createFromFormat(
            "Y-m-d H:i:s",
            $admin[0]["valid_at"]
        );
        $date2 = Carbon::now();
        $result = $date1->gt($date2);
        if (!$result) {
            return [
                "status" => false,
                "message" => __("common.error.token_expired"),
            ];
        }
        return [
            "status" => true
        ];
    }

    public function registerAccount($request)
    {
        DB::beginTransaction();
        try {
            $remember_token = hash_hmac("sha256", Str::random(40), config("app.key"));
            $dataMerchantStore = [
                "name" => $request->name,
                "status" => MerchantStoreStatus::TEMPORARILY_REGISTERED->value,
                "token" => $remember_token,
                "expires_at" => Carbon::now()->addHours(
                    config("const.EMAIL_VALID_DT")
                ),
            ];
            $merchantNumberByName = count($this->merchantStoreRepository->findByField('name', $request->name));

            if ($merchantNumberByName > 0) {
                throw new \Exception(__("admin_epay.merchant.common.merchant_name_exist"));
            }

            $merchantNumberByEmail = count($this->merchantUserRepository->findByField('email', $request->email));

            if ($merchantNumberByEmail > 0) {
                throw new \Exception(__("admin_epay.merchant.common.email_exist"));
            }

            $merchant_role = $this->merchantRoleRepository->where('name', \App\Enums\MerchantRole::OPERATOR->value)->first()->id;

            $dataMerchantUser = [
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "merchant_role_id" => $merchant_role,
            ];

            $merchantStore = $this->merchantStoreRepository->create($dataMerchantStore);
            $merchantUser = $this->merchantUserRepository->create($dataMerchantUser);
            $this->merchantStoreRepository->update(['merchant_user_owner_id' => $merchantUser->id], $merchantStore->id);
            $merchantUser->merchantStores()->sync(array_merge([], [$merchantStore->id]));

            DB::commit();

            try {
                SendEmailJob::dispatch(new CreateMerchantMail([
                    "name" => $request->name,
                    "email" => $request->email,
                    "password" => $request->password,
                    "url" => route("merchant.auth.verify-register", ["id" => $merchantStore->id, "token" => $remember_token])
                ]), $request->email)->onQueue('emails');
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
                throw new \Exception($e->getMessage());
            }

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            throw new \Exception($e->getMessage());
            return false;
        }

    }
}