<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldMerchantStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_stores', function (Blueprint $table) {
            $table->uuid('merchant_parent_store_id')->nullable()->comment('加盟店Parent ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('merchant_stores')) {
            Schema::table('merchant_stores', function (Blueprint $table) {
                $table->dropColumn('merchant_parent_store_id');
            });
        }
    }
}
