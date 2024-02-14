<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnToExchangeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('exchange_rates');
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary()->comment('ID');
            $table->char('merchant_store_id', 36);
            $table->decimal('jpy_jpy', 9, 2)->nullable();
            $table->decimal('usdc_jpy', 9, 2)->nullable();
            $table->decimal('usdt_jpy', 9, 2)->nullable();
            $table->decimal('dai_jpy', 9, 2)->nullable();
            $table->decimal('jpyc_jpy', 9, 2)->nullable();
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
        Schema::dropIfExists('exchange_rates');
    }
}
