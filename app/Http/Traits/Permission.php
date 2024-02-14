<?php

namespace App\Http\Traits;

use App\Models\ScreenPermissionRoles;
use Illuminate\Support\Facades\Cache;

trait Permission
{
    public function autoSetPermission($roleId, $screenName, $permissionName)
    {

        $status = false;
        if (!Cache::has($roleId)) {
            $this->saveCacheRoleAdmin($roleId);
        }
        $permission = Cache::get($roleId, []);
        if ($permissionList = $permission[$roleId][$screenName] ?? "") {
            if (in_array($permissionName, $permissionList)) {
                $status = true;
            }
        }
        return $status;
    }

    public function saveCacheRoleAdmin($roleId)
    {
        $rolePemissions = ScreenPermissionRoles::where("role_id", $roleId)
            ->select(
                "screen_permission_roles.role_id",
                "screens.name as screen_name",
                "permissions.name as permissions_name"
            )
            ->join(
                "screens",
                "screens.id",
                "=",
                "screen_permission_roles.screen_id"
            )
            ->join(
                "permissions",
                "permissions.id",
                "=",
                "screen_permission_roles.permission_id"
            )
            ->where("screen_permission_roles.active", true)
            ->get();
        $permission = [];
        if ($rolePemissions) {
            foreach ($rolePemissions as $val) {
                $permission[$roleId][$val->screen_name][] =
                    $val->permissions_name;
            }
            Cache::put($roleId, $permission, config("const.CACHE_TIME"));
            return;
        }
        Cache::put($roleId, $permission, config("const.CACHE_TIME"));
        return;
    }
}
