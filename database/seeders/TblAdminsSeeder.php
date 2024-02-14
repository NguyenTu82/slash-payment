<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admins;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminRole;
use App\Enums\AdminAccountStatus;

class TblAdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administratorRole = AdminRole::firstOrCreate([
            'name' => "administrator",
        ]);
        $operatorRole = AdminRole::firstOrCreate([
            'name' => "operator",
        ]);
        $admin = Admins::firstOrcreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => '千能',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'role_id' => $administratorRole->id,
                'status' => AdminAccountStatus::VALID->value,
            ]
        );

        // Create dummy merchant account
        for ($i = 1; $i <= 80; $i++) {
            if ($i < 40)
                $roleId = $administratorRole->id;
            else
                $roleId = $operatorRole->id;

            if ($i % 2 == 0)
                $status = AdminAccountStatus::INVALID->value;
            else
                $status = AdminAccountStatus::VALID->value;

            Admins::query()->firstOrcreate(
                [
                    'email' => 'admin' . $i . '@gmail.com'
                ],
                [
                    'name' => 'Admin ' . $i,
                    'email' => 'admin' . $i . '@gmail.com',
                    'password' => Hash::make('password'),
                    'role_id' => $roleId,
                    'status' => $status,
                ]
            );
        }


    }
}
