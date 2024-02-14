<?php

namespace App\Repositories;

use App\Enums\MerchantRole;
use App\Enums\MerchantStoreStatus;
use App\Models\MerchantUser;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class MerchantRepositoryEloquent.
 */
class MerchantUserRepositoryEloquent extends BaseRepository implements MerchantUserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MerchantUser::class;
    }

    /**
     * @param $email
     * @return mixed
     */
    public function findUserByEmail($email): mixed
    {
        return $this->model->newQuery()->where('email', $email)->first();
    }

    public function getProfile()
    {
        $merchantId = auth('merchant')->user()->id;

        return $this->model->newQuery()
            ->with([
                'merchantStores' => function ($query) {
                    $query->select('merchant_stores.id', 'name', 'payment_url')
                        ->where('merchant_stores.status', MerchantStoreStatus::IN_USE->value);
                },
            ])
            ->find($merchantId);
    }

    public function getMerchantUsers($request)
    {
        $merchant = auth('merchant')->user();
        $merchantRole = $merchant->role()->first();
        $merchantIds = $merchant->merchantStores()
            ->where('merchant_stores.status', MerchantStoreStatus::IN_USE->value)
            ->pluck('merchant_store_id')->all();
        // 管理者の場合、管理者の加盟店IDに基づいて全てユーザー取得
        if ($merchantRole->name == MerchantRole::ADMINISTRATOR->value)
            $query = $this->model->newQuery()
                ->whereHas('merchantStores', fn($q) => $q->whereIn('merchant_store_id', $merchantIds));
        else
            $query = $this->model->newQuery()->where('parent_user_id', $merchant->id)
                ->orWhere('id', $merchant->id);

        return $query->with('role')
            ->when(isset($request->status), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when(isset($request->role_id), function ($q) use ($request) {
                $q->where('merchant_role_id', $request->role_id);
            })
            ->when(isset($request->common), function ($q) use ($request) {
                $q->where(function ($subQuery) use ($request) {
                    $subQuery->where('user_code', (int) $request->common)
                        ->orWhere('name', 'like', '%' . $request->common . '%')
                        ->orWhere('email', 'like', '%' . $request->common . '%');
                });
            })->orderBy('user_code', 'desc');
    }

    public function findUserById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function deleteUserbyId($id)
    {
        return $this->model->findOrFail($id)->delete();
    }
}
