<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MerchantStore;
use App\Models\TransactionHistory;
use App\Models\PaymentSuccess;
use Illuminate\Support\Facades\Hash;
use App\Enums\TransactionHistoryPaymentStatus;

class TransactionHistoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $merchant_Store = MerchantStore::where('name', "加盟店 1")->first();
        $arr_money_unit=['USD', 'JPY', 'EUR', 'AED', 'SGD', 'HKD', 'CAD', 'IDR', 'PHP', 'INR', 'KRW'];
        $arr_cripto_unit=['USDT', 'USDC', 'DAI', 'JPYC'];
        $arr_network = ['ETH', 'BNB', 'Matic', 'AVAX', 'FTM', 'ARBITRUM_ETH', 'SOL'];
        $arr_status = ['requested', 'success', 'cancelled'];
        $arr_method = ['from_user', 'from_merchant'];

        if (isset($merchant_Store)) {
            $check = TransactionHistory::where('merchant_store_id', $merchant_Store->id)->first();
            if (isset($check)) {
            } else {
                for ($s = 0; $s <= 1; $s++) {
                    foreach ($arr_money_unit as $money) {
                        foreach ($arr_cripto_unit as $cripto) {
                            foreach ($arr_network as $network) {
                                foreach ($arr_status as $status) {
                                    foreach ($arr_method as $method) {
                                        $transaction_histories = TransactionHistory::query()->create(
                                            [
                                                'merchant_store_id' => $merchant_Store->id,
                                                'transaction_date' => '2023-05-2' . $s . ' 1' . $s . ':0' . $s . ':0' . $s,
                                                'payment_amount' => 10000 + $s * 10,
                                                'payment_asset' => $money,
                                                'received_amount' => 10000 + $s * 15,
                                                'received_asset' => $cripto,
                                                'network' => $network,
                                                'request_method' => $method,
                                                'payment_status' => $status,
                                                'payment_success_datetime' => '2023-05-2' . $s . ' 1' . $s . ':0' . $s . ':0' . $s,
                                                'hash' => Hash::make($money . $cripto . $network . $status),
                                            ]
                                        );
                                        if ($status == TransactionHistoryPaymentStatus::SUCCESS->value) {
                                            PaymentSuccess::query()->create(
                                                [
                                                    'transaction_history_id' => $transaction_histories->id,
                                                    'merchant_store_id' => $merchant_Store->id,
                                                    'payment_amount' => 10000 + $s * 10,
                                                    'payment_asset' => $money,
                                                    'received_amount' => 10000 + $s * 15,
                                                    'received_asset' => $cripto,
                                                    'network' => $network,
                                                    'request_method' => $method,
                                                    'created_at' => '2023-05-2' . $s . ' 1' . $s . ':0' . $s . ':0' . $s,
                                                ]
                                            );
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}