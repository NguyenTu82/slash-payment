<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMerchantCodeInMerchantStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_stores', function (Blueprint $table) {
            DB::statement('ALTER Table merchant_stores add merchant_code INTEGER NOT NULL UNIQUE AUTO_INCREMENT;');
            $table->uuid('merchant_user_owner_id')->nullable()->comment('加盟店主');
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
            DB::statement('ALTER Table merchant_stores drop merchant_code');
            $table->dropColumn("merchant_user_owner_id");
        });
    }
}
