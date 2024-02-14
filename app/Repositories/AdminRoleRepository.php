<?php

namespace App\Repositories;

use App\Models\AdminRole;

class AdminRoleRepository extends BaseRepository implements
    AdminRoleRepositoryInterface
{
    /**
     * getModel
     * @return string
     */
    public function getModel(): string
    {
        return AdminRole::class;
    }

    public function getRoleByAdminId($id)
    {
        return $this->model->select(
            "admin_roles.id",
            "admin_roles.name",
            "admin_roles.name_jp",
            "admin_roles.created_at",
            "admin_roles.updated_at"
        )
            ->where("admin_roles.id", $id)
            ->first();
    }

    public function getRoleByName($name)
    {
        return $this->model
            ->where("name", $name)
            ->first();
    }
}
