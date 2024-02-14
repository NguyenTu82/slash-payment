<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // seeder master table
        $this->call(AdminsRolesSeeder::class);
        $this->call(TblAdminsSeeder::class);
        $this->call(MerchantRolesSeeder::class);
        $this->call(MerchantUsersTableSeeder::class);
        $this->call(EpayReceiveNotificationFormatTableSeeder::class);
        $this->call(WithdrawLimitsTableSeeder::class);
    }
}
