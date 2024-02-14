<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableFiatWithdrawAccountsChangeAccountNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fiat_withdraw_accounts', function (Blueprint $table) {
            $table->string('bank_account_number',25)->comment('口座番号')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fiat_withdraw_accounts', function (Blueprint $table) {
            $table->integer('bank_account_number')->comment('口座番号');
        });
    }
}
