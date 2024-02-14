<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\MerchantRole;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class MerchantRoleRepositoryEloquent extends BaseRepository implements MerchantRoleRepository
{
    public function model(): string
    {
        return MerchantRole::class;
    }

    /**
     * @throws RepositoryException
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getRoles(): array|Collection
    {
        $merchantRole = auth('merchant')->user()->role()->first()->name;

        if ($merchantRole == \App\Enums\MerchantRole::ADMINISTRATOR->value)
            return $this->getAllRoles();

        if ($merchantRole == \App\Enums\MerchantRole::OPERATOR->value)
            return $this->model->newQuery()->whereIn('name', [
                \App\Enums\MerchantRole::OPERATOR->value,
                \App\Enums\MerchantRole::USER->value,
            ])->get();

        return $this->model->newQuery()->whereIn('name', [
            \App\Enums\MerchantRole::USER->value,
        ])->get();
    }

    public function getAllRoles(): array|Collection
    {
        return $this->model->all();
    }
}
