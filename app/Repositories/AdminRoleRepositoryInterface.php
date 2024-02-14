<?php

namespace App\Repositories;

interface AdminRoleRepositoryInterface extends RepositoryInterface
{
    public function getRoleByAdminId($id);
}
