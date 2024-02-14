<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WithdrawLimitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $withdraw_limits = [
            [
                'asset' => \App\Enums\TransactionHistoryMoneyUnit::USD->value,
                'asset_type' => 'bank',
                'once_min_withdraw' => 10,
                'once_max_withdraw' => 100000
            ],
            [
                'asset' => \App\Enums\TransactionHistoryMoneyUnit::JPY->value,
                'asset_type' => 'bank',
                'once_min_withdraw' => 10,
                'once_max_withdraw' => 10000000
            ],
            [
                'asset' => \App\Enums\TransactionHistoryMoneyUnit::EUR->value,
                'asset_type' => 'bank',
                'once_min_withdraw' => 10,
                'once_max_withdraw' => 100000
            ],
            [
                'asset' => \App\Enums\TransactionHistoryMoneyUnit::AED->value,
                'asset_type' => 'bank',
                'once_min_withdraw' => 10,
                'once_max_withdraw' => 100000
            ],
            [
                'asset' => \App\Enums\TransactionHistoryMoneyUnit::SGD->value,
                'asset_type' => 'bank',
                'once_min_withdraw' => 10,
                'once_max_withdraw' => 100000
            ],
            [
                'asset' => \App\Enums\TransactionHistoryMoneyUnit::HKD->value,
                'asset_type' => 'bank',
                'once_min_withdraw' => 10,
                'once_max_withdraw' => 100000
            ],
            [
                'asset' => \App\Enums\TransactionHistoryMoneyUnit::CAD->value,
                'asset_type' => 'bank',
                'once_min_withdraw' => 10,
                'once_max_withdraw' => 100000
            ],
            [
                'asset' => \App\Enums\TransactionHistoryMoneyUnit::IDR->value,
                'asset_type' => 'bank',
                'once_min_withdraw' => 10,
                'once_max_withdraw' => 100000
            ],
            [
                'asset' => \App\Enums\TransactionHistoryMoneyUnit::PHP->value,
                'asset_type' => 'bank',
                'once_min_withdraw' => 10,
                'once_max_withdraw' => 100000
            ],
            [
                'asset' => \App\Enums\TransactionHistoryMoneyUnit::INR->value,
                'asset_type' => 'bank',
                'once_min_withdraw' => 10,
                'once_max_withdraw' => 100000
            ],
            [
                'asset' => \App\Enums\TransactionHistoryMoneyUnit::KRW->value,
                'asset_type' => 'bank',
                'once_min_withdraw' => 10,
                'once_max_withdraw' => 100000
            ],
            [
                'asset' => \App\Enums\TransactionHistoryCryptoUnit::USDT->value,
                'asset_type' => 'crypto',
                'once_min_withdraw' => 10,
                'once_max_withdraw' => 100000
            ],
            [
                'asset' => \App\Enums\TransactionHistoryCryptoUnit::USDC->value,
                'asset_type' => 'crypto',
                'once_min_withdraw' => 10,
                'once_max_withdraw' => 100000
            ],
            [
                'asset' => \App\Enums\TransactionHistoryCryptoUnit::DAI->value,
                'asset_type' => 'crypto',
                'once_min_withdraw' => 10,
                'once_max_withdraw' => 100000
            ],
            [
                'asset' => \App\Enums\TransactionHistoryCryptoUnit::JPYC->value,
                'asset_type' => 'crypto',
                'once_min_withdraw' => 10,
                'once_max_withdraw' => 100000
            ],
        ];
        foreach ($withdraw_limits as $item) {
            DB::table('withdraw_limits')->updateOrInsert(['asset' => $item['asset']], $item);
        }
    }
}
