<?php

namespace Database\Seeders;

use App\Traits\Uuid;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class MerchantRolesSeeder extends Seeder
{
    use Uuid;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $uuid = $this->uuid();

        // roles
        $roles = [
            ['name' => 'administrator', 'name_jp' => '管理者'],
            ['name' => 'operator', 'name_jp' => '運用者'],
            ['name' => 'user', 'name_jp' => '利用者'],
        ];
        foreach ($roles as $item) {
            DB::table('merchant_roles')->updateOrInsert(['name' => $item['name']], $item);
        }
    }
}
