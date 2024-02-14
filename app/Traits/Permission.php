<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait Permission
{
    public array $namePermissionArr = [
        'create' => 'create',
        'read' => 'read',
        'update' => 'update',
        'delete' => 'delete',
    ];

    public function getArrIdPermissions(): array
    {
        $result = [];
        $permissions = DB::table('permissions')->get()->toArray();

        foreach ($permissions as $permission) {
            switch (true) {
                case $permission->name == $this->namePermissionArr['create']:
                    $result[$this->namePermissionArr['create']] = $permission->id;
                    break;
                case $permission->name == $this->namePermissionArr['read']:
                    $result[$this->namePermissionArr['read']] = $permission->id;
                    break;
                case $permission->name == $this->namePermissionArr['update']:
                    $result[$this->namePermissionArr['update']] = $permission->id;
                    break;
                case $permission->name == $this->namePermissionArr['delete']:
                    $result[$this->namePermissionArr['delete']] = $permission->id;
                    break;
            }
        }

        return $result;
    }
}
