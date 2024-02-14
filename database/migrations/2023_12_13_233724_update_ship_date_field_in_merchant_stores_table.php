<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateShipDateFieldInMerchantStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_stores', function (Blueprint $table) {
            $table->integer('ship_date')->nullable()->comment('0:月末, 1:毎週末, 2:隔週末')->change();
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
            $table->datetime('ship_date')->nullable()->comment('発送日設定');
        });
    }
}
