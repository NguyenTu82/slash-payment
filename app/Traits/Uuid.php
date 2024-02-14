<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait Uuid
{
    public function uuid(): array
    {
        $result = [
            'idAdministrator' => Str::uuid(),
            'idOperator' => Str::uuid(),
            'idMerchantAdmin' => Str::uuid(),
            'idAfAdmin' => Str::uuid()
        ];
        $roles = DB::table('admin_roles')->select('*')->get()->toArray();

        foreach ($roles as $role) {
            switch (true) {
                case $role->name == 'administrator':
                    $result['idAdministrator'] = $role->id;
                    break;
                case $role->name == 'operator':
                    $result['idOperator'] = $role->id;
                    break;
                // case $role->name == 'merchent_admin':
                //     $result['idMerchantAdmin'] = $role->id;
                //     break;
                // case $role->name == 'af_admin':
                //     $result['idMerchantAdmin'] = $role->id;
                //     break;
            }
        }

        return $result;
    }
}
