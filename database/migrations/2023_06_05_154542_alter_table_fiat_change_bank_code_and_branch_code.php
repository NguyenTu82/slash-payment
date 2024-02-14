<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableFiatChangeBankCodeAndBranchCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fiat_withdraw_accounts', function (Blueprint $table) {
            $table->string('bank_code',25)->comment('金融機関コード')->change();
            $table->string('branch_code',25)->comment('支店コード')->change();
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
            $table->integer('bank_code')->comment('金融機関コード');
            $table->integer('branch_code')->comment('支店コード');
        });
    }
}
