<?php

namespace App\Repositories;

use App\Models\AdminTokens;
use Carbon\Carbon;

class AdminTokenRepository extends BaseRepository implements
    AdminTokenRepositoryInterface
{
    /**
     * getModel
     * @return string
     */
    public function getModel(): string
    {
        return AdminTokens::class;
    }

    public function getUserTokenByEmail($email)
    {
        return AdminTokens::where([
            ["email", $email],
            ["valid_at", ">=", Carbon::now()],
        ])
            ->select("token")
            ->get();
    }

    public function getPhoneTokenByEmailAndValid()
    {
        return AdminTokens::where([
            [
                "email",
                object_get(auth('epay')->user(), "email"),
            ],
            ["valid_at", ">=", Carbon::now()],
        ])
            ->orderBy("valid_at", "desc")
            ->first();
    }

    public function createOrUpdate($email, $array = [])
    {
        return AdminTokens::updateOrCreate(
            ["email" => $email],
            $array
        );
    }
}
