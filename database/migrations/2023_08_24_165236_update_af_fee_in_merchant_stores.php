<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAfFeeInMerchantStores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_stores', function (Blueprint $table) {
            $table->decimal('af_fee', 10, 1)->nullable()->comment('AF手数料')->change();
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
            $table->integer('af_fee')->nullable()->comment('AF手数料');
        });
    }
}
