<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldMemoInCryptoWithdrawAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crypto_withdraw_accounts', function (Blueprint $table) {
            $table->text('note')->nullable()->comment('備考欄');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crypto_withdraw_accounts', function (Blueprint $table) {
            $table->dropColumn('note');
        });
    }
}
