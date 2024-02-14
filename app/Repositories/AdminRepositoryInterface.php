<?php

namespace App\Repositories;

interface AdminRepositoryInterface extends RepositoryInterface
{
    /**
     * Get data list Admin
     * @return mixed
     */
    public function getDataListAdmin();

    /**
     * Get roles
     * @return mixed
     */
    public function getRoles();

    /**
     * Get role id
     * @return mixed
     */
    public function getRoleId($id);

    public function getAdminById($id, $roleId = null);
    public function resetPassword($email, $password);
    public function getuserForgotPass($email);
    public function getAccounts($request);
    public function getAdmins();
}
