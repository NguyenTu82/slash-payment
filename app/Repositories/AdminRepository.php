<?php

namespace App\Repositories;

use App\Enums\AdminAccountStatus;
use App\Models\AdminRole;
use App\Models\Admins;
use Illuminate\Support\Facades\Hash;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{
    /**
     * getModel
     * @return string
     */
    public function getModel(): string
    {
        return Admins::class;
    }

    /**
     * Get data list Admin
     * @return mixed
     */
    public function getDataListAdmin()
    {
        return $this->model->
            select(
                "admins.*",
                "admin_roles.name_jp",
            )
            ->join('admin_roles','admin_roles.id','admins.role_id')
            ->orderBy('email_verified_at', 'desc');
    }

    /**
     * Get roles
     * @return mixed
     */
    public function getRoles()
    {
        return AdminRole::query()->get();
    }

    /**
     * Get roles
     * @return mixed
     */
    public function getRoleId($id)
    {
        return AdminRole::find($id);
    }

    public function getAdminById($id, $roleId = null)
    {
        $query = $this->model
            ->select(
                "admins.*",
                "admin_roles.id as role_id",
                "admin_roles.name as role_name",
                "admin_roles.name_jp"
            )
            ->join("admin_roles", "admins.role_id", "=", "admin_roles.id")
            ->where("admins.id", $id);
        if ($roleId) {
            $query->where("admins.role_id", $roleId);
        }
        return $query->first();
    }
    public function resetPassword($email, $password)
    {
        $this->model->where("email",$email)
        ->update(["password" => Hash::make($password)]);
    }

    public function getuserForgotPass($email)
    {
        return $this->model->where("email", $email)
            ->where("status", AdminAccountStatus::VALID)
            ->whereNull('deleted_at')
            ->first();
    }

    public function getAccounts($request)
    {
        return $this->model->select(
            "admins.*",
            "admin_roles.name_jp",
            "admin_roles.name as role_name",
        )
        ->join('admin_roles','admin_roles.id','admins.role_id')
        ->when(isset($request->status), function ($query) use ($request) {
            $query->where('admins.status', $request->status);
        })
        ->when(isset($request->role_id), function ($query) use ($request) {
            $query->where('admins.role_id', $request->role_id);
        })
        ->when(isset($request->common), function ($query) use ($request) {
            $query->where(function ($subQuery) use ($request) {
                $subQuery->where('admins.user_code', (int) $request->common)
                    ->orWhere('admins.email', 'like', "%$request->common%")
                    ->orWhere('admins.name', 'like', "%$request->common%");
            });
        })
        ->orderBy('user_code', 'desc');
    }

    public function getAdmins()
    {
        return $this->model
            ->select('id', 'email')
            ->where('status', AdminAccountStatus::VALID->value)
            ->get();
    }

    public function getAdminByName($name)
    {
        return $this->model
            ->where('email', $name)
            ->get();
    }

    public function findAdminByIdAndToken($id, $token)
    {
        return $this->model
            ->where('id', $id)
            ->where('token', $token)
            ->first();
    }

    public function updateStatusInAdmin($status, $id)
    {
        return $this->model
            ->find($id)
            ->update(["status" => $status]);
    }
}
