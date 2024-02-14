<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnToWithdrawMethodMerchantStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_stores', function (Blueprint $table) {
            $table->dropColumn('payment_currency');
            $table->enum('withdraw_method', ['cash', 'banking', 'crypto'])->after('payment_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withdraw_method_merchant_stores', function (Blueprint $table) {
            $table->dropColumn('withdraw_method');
            $table->tinyInteger('payment_currency')->after('payment_url');
        });
    }
}
