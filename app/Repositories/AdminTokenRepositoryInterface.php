<?php

namespace App\Repositories;

interface AdminTokenRepositoryInterface extends RepositoryInterface
{
    public function getUserTokenByEmail($email);

    public function getPhoneTokenByEmailAndValid();

    public function createOrUpdate($email, $array);
}
