<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnToMerchantStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_stores', function (Blueprint $table) {
            DB::statement('alter table merchant_stores change column payment_cycle payment_cycle tinyint comment \'支払いサイクル (1:　週末払い, 2: 月末払い\'');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('merchant_stores', function (Blueprint $table) {
            $table->string('payment_cycle', 255)->nullable()->comment('支払いサイクル')->change();
        });
    }
}
