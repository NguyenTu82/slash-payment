<?php

namespace Database\Seeders;

use App\Enums\MerchantUserStatus;
use App\Enums\MerchantStoreStatus;
use App\Models\MerchantGroup;
use App\Models\MerchantRole;
use App\Models\MerchantStore;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\MerchantUser;
use Illuminate\Support\Facades\Hash;

class MerchantUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $administratorRole = MerchantRole::query()->firstOrCreate(['name' => "administrator"]);
        $operatorRole = MerchantRole::query()->firstOrCreate(['name' => "operator"]);
        $userRole = MerchantRole::query()->firstOrCreate(['name' => "user"]);

        // Create merchant master account
        $initSupperAdmin = MerchantUser::query()->firstOrcreate(
            [
                'email' => 'merchant@bap.jp'
            ],
            [
                'name' => 'Merchant BAP Group',
                'email' => 'merchant@bap.jp',
                'password' => Hash::make('password'),
                'merchant_role_id' => $administratorRole->id,
                'status' => MerchantUserStatus::VALID->value,
            ]
        );

        // Create dummy merchant account
        for ($i = 1; $i <= 120; $i++) {
            if ($i < 40)
                $roleId = $administratorRole->id;
            elseif ($i > 40 && $i <= 80)
                $roleId = $operatorRole->id;
            else
                $roleId = $userRole->id;

            if ($i%3 == 2)
                $status = MerchantUserStatus::INVALID->value;
            else
                $status = MerchantUserStatus::VALID->value;

            MerchantUser::query()->firstOrcreate(
                [
                    'email' => 'merchant001@gmail.com'
                ],
                [
                    'name' => 'Merchant '.$i,
                    'email' => 'merchant'.$i.'@gmail.com',
                    'password' => Hash::make('password'),
                    'merchant_role_id' => $roleId,
                    'parent_user_id' => $initSupperAdmin->id,
                    'status' => $status,
                ]
            );
        }

        // Create dummy merchant store
        for ($s = 1; $s <= 120; $s++) {
            MerchantStore::query()->firstOrcreate(
                [
                    'name' => '加盟店 '.$s,
                ],
                [
                    'name' => '加盟店 '.$s,
                    'payment_url' => 'https://dev.crypto-epay.io/payment/'.Str::uuid(),
                    'status' => MerchantStoreStatus::IN_USE->value,
                ]
            );
        }

        $stores = MerchantStore::query()->paginate(10);
        foreach ($stores as $store) {
            MerchantGroup::query()->firstOrcreate(
                [
                    'merchant_store_id' => $store->id,
                ],
                [
                    'merchant_store_id' => $store->id,
                    'merchant_user_id' => $initSupperAdmin->id,
                ]
            );
        }
    }
}
