<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraw_limits', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primay()->comment('ID');
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
            $table->enum('asset_type', ['bank', 'crypto'])->nullable()->comment('資産タイプ');
            $table->decimal('once_min_withdraw', 10, 2)->nullable()->comment('1回最低限の出金');
            $table->decimal('once_max_withdraw', 10, 2)->nullable()->comment('1回最大限の出金');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdraw_limits');
    }
}
