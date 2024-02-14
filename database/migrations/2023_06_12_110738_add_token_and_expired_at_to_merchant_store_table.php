<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTokenAndExpiredAtToMerchantStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_stores', function (Blueprint $table) {
            $table->string('token', 255)->nullable()->comment('トークン');
            $table->datetime('expires_at')->nullable()->comment('トークン有効期限');
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
            $table->dropColumn('token');
            $table->dropColumn('expires_at');
        });
    }
}
