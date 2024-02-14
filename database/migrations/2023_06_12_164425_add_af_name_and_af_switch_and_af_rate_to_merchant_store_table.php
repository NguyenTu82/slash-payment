<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAfNameAndAfSwitchAndAfRateToMerchantStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_stores', function (Blueprint $table) {
            $table->string('af_name', 255)->nullable()->comment('AF名');
            $table->integer('af_fee')->nullable()->comment('AF手数料');
            $table->integer('af_switch')->nullable()->comment('AF手数料');
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
            $table->dropColumn('af_name');
            $table->dropColumn('af_fee');
            $table->dropColumn('af_switch');
        });
    }
}
