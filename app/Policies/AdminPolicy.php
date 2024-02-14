<?php

namespace App\Policies;

use App\Models\Admins;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Enums\Permission as EnumsPermission;
use App\Enums\Screen;
use App\Http\Traits\Permission;

class AdminPolicy
{
    use HandlesAuthorization;
    use Permission;

    public string|null $roleId;

    public function __construct()
    {
        $this->roleId = session()->get("admin_roles.role_id");
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return mixed
     */
    public function view()
    {   
        return $this->autoSetPermission(
            $this->roleId,
            Screen::ADMIN->value,
            EnumsPermission::READ->value
        );
    }

    /**
     * Determine whether the user can create models.
     *
     * @return mixed
     */
    public function create()
    {
        return $this->autoSetPermission(
            $this->roleId,
            Screen::ADMIN->value,
            EnumsPermission::CREATE->value
        );
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return mixed
     */
    public function update()
    {
        return $this->autoSetPermission(
            $this->roleId,
            Screen::ADMIN->value,
            EnumsPermission::UPDATE->value
        );
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return mixed
     */
    public function delete()
    {
        return $this->autoSetPermission(
            $this->roleId,
            Screen::ADMIN->value,
            EnumsPermission::DELETE->value
        );
    }
}
