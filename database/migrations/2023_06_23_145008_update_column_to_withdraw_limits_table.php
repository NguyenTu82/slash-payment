<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnToWithdrawLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE withdraw_limits MODIFY asset ENUM('USD', 'JPY', 'EUR', 'AED', 'SGD', 'HKD', 'CAD', 'IDR', 'PHP', 'INR', 'KRW', 'USDT', 'USDC', 'DAI', 'JPYC') NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withdraw_limits', function (Blueprint $table) {
            $table->enum('asset', [
                \App\Enums\TransactionHistoryMoneyUnit::USD->value,
                \App\Enums\TransactionHistoryMoneyUnit::JPY->value,
                \App\Enums\TransactionHistoryMoneyUnit::EUR->value,
                \App\Enums\TransactionHistoryMoneyUnit::AED->value,
                \App\Enums\TransactionHistoryMoneyUnit::SGD->value,
                \App\Enums\TransactionHistoryMoneyUnit::HKD->value,
                \App\Enums\TransactionHistoryMoneyUnit::CAD->value,
                \App\Enums\TransactionHistoryMoneyUnit::IDR->value,
                \App\Enums\TransactionHistoryMoneyUnit::PHP->value,
                \App\Enums\TransactionHistoryMoneyUnit::INR->value,
                \App\Enums\TransactionHistoryMoneyUnit::KRW->value,
                \App\Enums\TransactionHistoryCryptoUnit::USDT->value,
                \App\Enums\TransactionHistoryCryptoUnit::USDC->value,
                \App\Enums\TransactionHistoryCryptoUnit::DAI->value,
                \App\Enums\TransactionHistoryCryptoUnit::JPYC->value,
            ])->nullable()->comment('資産');
        });
    }
}