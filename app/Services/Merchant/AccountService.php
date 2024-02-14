<?php

namespace App\Services\Merchant;

use App\Jobs\SendEmailJob;
use App\Mail\CreateAccountMail;
use App\Repositories\MerchantGroupRepository;
use App\Repositories\MerchantUserRepository;
use App\Repositories\MerchantRoleRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AccountService
{
    protected MerchantUserRepository $merchantUserRepository;
    protected MerchantRoleRepository $merchantRoleRepository;
    protected MerchantGroupRepository $merchantGroupRepository;

    public function __construct(
        MerchantUserRepository $merchantUserRepository,
        MerchantRoleRepository $merchantRoleRepository,
        MerchantGroupRepository $merchantGroupRepository
    ){
        $this->merchantUserRepository = $merchantUserRepository;
        $this->merchantRoleRepository = $merchantRoleRepository;
        $this->merchantGroupRepository = $merchantGroupRepository;
    }

    public function getRoles()
    {
        return $this->merchantRoleRepository->getRoles();
    }

    public function accounts($request)
    {
        return $this->merchantUserRepository->getMerchantUsers($request);
    }

    public function findMerchantStoreOfUserLogin()
    {
        return $this->merchantGroupRepository->findmerchantstorebyuser();
    }

    public function createMerchantUser($data)
    {
        DB::beginTransaction();
        try {
            $merchant = $this->merchantUserRepository->create($data);
            $merchant->merchantStores()->sync($data['merchant_store_ids']);
            $mailInfo = [
                "name" => $data["name"],
                "email" => $data["email"],
                "password" => $data["password_not_hash"],
                "site" => "MERCHANT",
                "url" => route("merchant.auth.login")
            ];
            try {
                SendEmailJob::dispatch(new CreateAccountMail($mailInfo), $data["email"])->onQueue('emails');
            } catch (Exception $e) {
                Log::error("SNS-ERROR:" . $e->getMessage());
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return false;
        }
    }

    public function findUserById($request)
    {
        return $this->merchantUserRepository->findUserById($request);
    }

    public function deleteUserbyId($request)
    {
        return $this->merchantUserRepository->deleteUserbyId($request);
    }

    public function UpdateMerchantUser($data)
    {
        DB::beginTransaction();
        try {
            $merchant = $this->merchantUserRepository->update($data,$data["id"]);
            $merchant->merchantStores()->sync($data['merchant_store_ids']);
            DB::commit();
            return $merchant;

        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
        }
    }

    public function changePasswordAccount($id, $data)
    {
        return $this->merchantUserRepository->update($data,$id);
    }
}
