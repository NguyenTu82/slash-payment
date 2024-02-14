<?php

namespace App\Repositories;

use App\Models\Admins;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * getModel
     * @return string
     */
    public function getModel(): string
    {
        return Admins::class;
    }
}
