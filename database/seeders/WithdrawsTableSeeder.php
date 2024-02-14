<?php

namespace Database\Seeders;

use App\Models\MerchantGroup;
use App\Models\MerchantUser;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WithdrawsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('withdraws')->truncate();
        $faker = Faker::create();

        $merchantUser = MerchantUser::where('email', 'merchant@bap.jp')->first();
        $merchantUserID = $merchantUser->id ?? '';
        $ownerStores = MerchantGroup::where('merchant_user_id', $merchantUserID)->pluck('merchant_store_id')->toArray();

        // Generate fake data
        for ($i = 0; $i < 20; $i++) {
            $orderId = $faker->text(20);
            $orderId = substr($orderId, 0, 20);

            $fiatWithdrawAccountId = null;
            $cryptoWithdrawAccountId = null;
            if ($faker->boolean) {
                $fiatWithdrawAccountId = $faker->uuid;
            } else {
                $cryptoWithdrawAccountId = $faker->uuid;
            }

            $currentDateTime = Carbon::now();
            $approveDateTime = $currentDateTime->copy()->addDays(5);

            $withdrawStatus = $faker->randomElement(['waiting_approve', 'processing', 'denied', 'succeeded']);
            $approveDateTime = $withdrawStatus === 'succeeded' ? $approveDateTime : null;
            $adminApproveId = $withdrawStatus === 'succeeded' ? $faker->uuid : null;

            DB::table('withdraws')->insert([
                'id' => $faker->uuid,
                'order_id' => $orderId,
                'merchant_store_id' => $faker->randomElement($ownerStores),
                'admin_approve_id' => $adminApproveId,
                'withdraw_method' => $faker->randomElement(['cash', 'banking', 'crypto']),
                'withdraw_request_method' => $faker->randomElement(['manual', 'auto']),
                'withdraw_status' => $withdrawStatus,
                'amount' => $faker->randomFloat(2, 0, 1000),
                'asset' => $faker->randomElement(['USDT', 'DAI']),
                'hash' => $faker->uuid,
                'fiat_withdraw_account_id' => $fiatWithdrawAccountId,
                'crypto_withdraw_account_id' => $cryptoWithdrawAccountId,
                'approve_datetime' => $approveDateTime,
                'created_at' => $currentDateTime,
                'updated_at' => $currentDateTime,
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
