<?php
declare(strict_types = 1);

namespace App\Services\Merchant;

use App\Models\MerchantRole;
use App\Models\MerchantUser;
use App\Repositories\MerchantRoleRepository;
use App\Repositories\MerchantUserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Exception;

class MerchantService
{
    protected MerchantUserRepository $merchantUserRepository;

    protected MerchantRoleRepository $merchantRoleRepository;

    /**
     * @param MerchantUserRepository $merchantUserRepository
     * @param MerchantRoleRepository $merchantRoleRepository
     */
    public function __construct(
        MerchantUserRepository $merchantUserRepository,
        MerchantRoleRepository $merchantRoleRepository,
    ) {
        $this->merchantUserRepository = $merchantUserRepository;
        $this->merchantRoleRepository = $merchantRoleRepository;
    }

    public function findUserValid($data)
    {
        return $this->merchantUserRepository->findWhere($data);
    }

    public function getRoles(): ?MerchantRole
    {
        return $this->merchantRoleRepository->getRoles();
    }

    public function getAllRoles()
    {
        return $this->merchantRoleRepository->getAllRoles();
    }

    public function getProfile()
    {
        return $this->merchantUserRepository->getProfile();
    }

    public function changePassword($data): JsonResponse
    {
        $this->merchantUserRepository->update($data, auth('merchant')->user()->id);

        return response()->json([
            'status' => true,
            'message' => 'Password changed successfully',
        ]);
    }

    public function updateProfile($data): JsonResponse|array
    {
        DB::beginTransaction();
        try {
            $merchantId = auth('merchant')->user()->id;
            $this->merchantUserRepository->update($data, $merchantId);

            $storeIds = $data['store_ids'] ?? [];
            auth('merchant')->user()->getMerchantStore->groups()->sync($storeIds);
            auth('merchant')->user()->merchantStores()->sync($storeIds);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'update successful',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();

            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function getStoresAssigned()
    {
        return auth('merchant')->user()
            ->merchantStores()
            ->select('merchant_stores.id',
                'merchant_stores.name',
                'merchant_stores.merchant_code',
                'merchant_stores.merchant_user_owner_id',
                'merchant_stores.withdraw_method',
            )->get();
    }
}
