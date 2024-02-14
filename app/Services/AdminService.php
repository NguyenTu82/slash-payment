<?php

namespace App\Services;

use App\Jobs\SendEmailJob;
use App\Mail\CreateAccountMail;
use App\Repositories\AdminRepositoryInterface;
use App\Repositories\AdminRoleRepositoryInterface;
use App\Repositories\AdminTokenRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use \App\Enums\MerchantUserStatus;
use \App\Enums\AdminRole;
use App\Mail\CreateMerchantMail;

class AdminService
{
    private AdminRepositoryInterface $adminRepository;
    private AdminRoleRepositoryInterface $roleRepository;
    private AdminTokenRepositoryInterface $adminTokenRepository;

    public function __construct(
        AdminRepositoryInterface $adminRepository,
        AdminRoleRepositoryInterface $roleRepository,
        AdminTokenRepositoryInterface $adminTokenRepository
    ) {
        $this->adminRepository = $adminRepository;
        $this->roleRepository = $roleRepository;
        $this->adminTokenRepository = $adminTokenRepository;
    }

    /**
     * List Admin Paginate
     *
     * @return mixed
     */
    public function listAdminPaginate()
    {
        $data = $this->adminRepository->getDataListAdmin()->paginate(config('const.LIMIT_PAGINATION'), ['*']);
        $dataCsv = $this->adminRepository->getDataListAdmin()->get();
        return ["data" => $data, "dataCsv" => $dataCsv];
    }

    /**
     * Get role
     *
     * @return mixed
     */
    public function getRoles()
    {
        return $this->adminRepository->getRoles();
    }

    /**
     * Get info admin
     *
     * @return mixed
     */
    public function getInfoAdmin($id)
    {
        return $this->adminRepository->find($id);
    }

    /**
     * Save data Admin
     *
     * @return mixed
     */
    public function saveDataAdmin($request)
    {
        DB::beginTransaction();
        try {
            $token = hash_hmac("sha256", Str::random(40), config("app.key"));
            $dataAdminArr = [
                'name' => $request->name,
                "role_id" => $request->role_id,
                'status' => MerchantUserStatus::VALID->value,
                'note' => $request->note,
                'email' => $request->email,
                "token" => $token,
                "password" => Hash::make($request->password),
                "expires_at" => Carbon::now()->addHours(
                    config("const.EMAIL_VALID_DT")
                ),
            ];
            // Create table Admin
            $admins = $this->adminRepository->create($dataAdminArr);
            // Create Table Roles Admin

            // Send Mail
            $mailInfo = [
                "name" => $request->name,
                "email" => $request->email,
                "password" => $request->password,
                "site" => "EPAY",
                "url" => route("admin_epay.auth.login"),
            ];
            try {
                SendEmailJob::dispatch(new CreateAccountMail($mailInfo), $request->email)->onQueue('emails');
            } catch (Exception $e) {
                Log::error("SNS-ERROR:" . $e->getMessage());
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return $e->getMessage();
        }
    }

    /**
     * Update data Admin
     *
     * @return mixed
     */
    public function updateDataAdmin($request, $id)
    {
        DB::beginTransaction();
        try {
            $dataAdminArr = [
                'name' => $request->name,
                'account_id' => $request->account_id,
                'role_id' => $request->role_id
            ];
            // Get data admin info
            $admins = $this->adminRepository->find($id);
            // Update table Admin
            $this->adminRepository->update($id, $dataAdminArr);
            DB::commit();
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function delete($request)
    {
        try {
            $adminData = $this->adminRepository
                ->delete($request->ids);
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    public function verify($request)
    {
        $verifyUser = $this->adminRepository->findOneBy([
            "token" => $request->token,
        ]);
        if (empty($verifyUser)) {
            return [
                "status" => false,
                "message" => __("admin_epay.messages.token_is_invalid"),
            ];
        }
        $date1 = Carbon::createFromFormat(
            "Y-m-d H:i:s",
            $verifyUser["expires_at"]
        );
        $date2 = Carbon::now();
        $result = $date1->gt($date2);
        if (!$result) {
            return [
                "status" => false,
                "message" => __("admin_epay.messages.URL_expired_please_log_in_again"),
            ];
        }
        return [
            "status" => true,
            "data" => $verifyUser,
        ];
    }

    public function updateInfoAdmin($request)
    {
        DB::beginTransaction();
        try {
            $admin = $this->adminRepository->findOneBy([
                "email" => $request->email,
            ]);
            $dataAdminArr = [
                "password" => Hash::make($request->password),
                "email_verified_at" => Carbon::now(),
                "token" => null,
                "expires_at" => null,
            ];
            // Update table Admin
            $this->adminRepository->update($admin["id"], $dataAdminArr);
            DB::commit();
            return [
                "status" => true,
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return [
                "status" => false,
                "message" => $e->getMessage(),
            ];
        }
    }

    public function getRoleByAdmin($id = 0)
    {
        return $this->roleRepository->getRoleByAdminId($id);
    }

    public function getAdminById($id, $roleId = null)
    {
        return $this->adminRepository->getAdminById($id, $roleId);
    }

    public function resetPassword($request)
    {
        DB::beginTransaction();
        try {
            $admin = $this->adminTokenRepository->findOneBy([
                "email" => $request->email,
            ]);
            if (empty($admin)) {
                return [
                    "status" => false,
                    "message" => __("common.error.token_expired"),
                ];
            }
            if ($admin["token"] != $request->token) {
                return [
                    "status" => false,
                    "message" => __("common.error.token_invalid"),
                ];
            }

            $date1 = Carbon::createFromFormat(
                "Y-m-d H:i:s",
                $admin["valid_at"]
            );
            $date2 = Carbon::now();
            $result = $date1->gt($date2);
            if (!$result) {
                return [
                    "status" => false,
                    "message" => __("common.error.token_expired"),
                ];
            }
            // Update table Admin

            $this->adminRepository->resetPassword($admin["email"], $request->password);
            $this->adminTokenRepository->delete($admin["id"]);
            DB::commit();
            return [
                "status" => true,
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return [
                "status" => false,
                "message" => $e->getMessage(),
            ];
        }
    }

    public function changePassword($request)
    {
        #Update the new Password
        $this->adminRepository->update(auth('epay')->user()->id, ["password" => Hash::make($request->password)]);
        return response()->json([
            'status' => true,
            'message' => 'Password changed successfully'
        ]);
    }

    /**
     *  updateProfile admin
     *
     * @param $data
     * @return array
     */
    public function updateProfile($data)
    {
        DB::beginTransaction();
        try {
            $this->adminRepository->update(
                auth('epay')->user()->id,
                $data
            );

            DB::commit();
            return [
                "status" => true,
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return [
                "status" => false,
                "message" => $e->getMessage(),
            ];
        }
    }

    public function getAccounts($request)
    {
        return $this->adminRepository->getAccounts($request);
    }
    public function checkToken($request)
    {
        $admin = $this->adminTokenRepository->findOneBy([
            "email" => $request->email,
        ]);
        if (empty($admin)) {
            return [
                "status" => false,
                "message" => __("common.error.token_expired"),
            ];
        }
        if ($admin["token"] != $request->token) {
            return [
                "status" => false,
                "message" => __("common.error.token_invalid"),
            ];
        }
        $date1 = Carbon::createFromFormat(
            "Y-m-d H:i:s",
            $admin["valid_at"]
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
            $rolo_id = $this->roleRepository->getRoleByName(AdminRole::OPERATOR->value)->id;
            $token = hash_hmac("sha256", Str::random(40), config("app.key"));
            $dataAdmin = [
                'name' => $request->name,
                "role_id" => $rolo_id,
                'status' => MerchantUserStatus::INVALID->value,
                'email' => $request->email,
                "token" => $token,
                "password" => Hash::make($request->password),
                "expires_at" => Carbon::now()->addHours(
                    config("const.EMAIL_VALID_DT")
                ),
            ];

            $accountNumberByEmail = count($this->adminRepository->getAdminByName($request->email));
            if ($accountNumberByEmail > 0) {
                throw new Exception(__("admin_epay.merchant.common.email_exist"));
            }

            // Create table Admin
            $admins = $this->adminRepository->create($dataAdmin);
            DB::commit();

            try {
                SendEmailJob::dispatch(new CreateMerchantMail([
                    "name" => $request->name,
                    "email" => $request->email,
                    "password" => $request->password,
                    "url" => route("admin_epay.auth.verify-register", ["id" => $admins->id, "token" => $token])
                ]), $request->email)->onQueue('emails');
            } catch (Exception $e) {
                Log::error($e->getMessage());
                throw new Exception($e->getMessage());
            }

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
            return false;
        }

    }

    public function verifyRegisterAccount($id, $token): array
    {
        $dataAccount = $this->adminRepository->findAdminByIdAndToken($id, $token);
        if (!$dataAccount) {
            return [
                "status" => false,
                "messages" => __("admin_epay.merchant.common.verify_url_error"),
            ];
        }
        $date1 = Carbon::createFromFormat(
            "Y-m-d H:i:s",
            $dataAccount["expires_at"]
        );
        $date2 = Carbon::now();
        $result = $date1->gt($date2);
        if (!$result) {
            return [
                "status" => false,
                "messages" => __("admin_epay.merchant.common.verify_url_expires"),
            ];
        }
        $this->adminRepository->updateStatusInAdmin(MerchantUserStatus::VALID->value, $id);

        return [
            "status" => true,
        ];
    }
}