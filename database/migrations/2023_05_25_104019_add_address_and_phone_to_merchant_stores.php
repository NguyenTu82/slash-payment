<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressAndPhoneToMerchantStores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_stores', function (Blueprint $table) {
            $table->string('address', 255)->nullable()->comment('住所');
            $table->string('phone', 20)->nullable()->comment('携帯番号');
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
            $table->dropColumn('address');
            $table->dropColumn('phone');
        });
    }
}
