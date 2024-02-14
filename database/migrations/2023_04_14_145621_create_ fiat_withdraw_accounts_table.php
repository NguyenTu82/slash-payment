<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiatWithdrawAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiat_withdraw_accounts', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary()->comment('ID');
            $table->uuid('merchant_store_id')->comment('加盟店ID');
            $table->string('financial_institution_name', 255)->comment('金融機関名');
            $table->integer('bank_code')->comment('金融機関コード');
            $table->string('branch_name', 255)->comment('支店名');
            $table->integer('branch_code')->comment('支店コード');
            $table->tinyInteger('bank_account_type')->comment('口座種別(0: 普通, 1: 定期, 2:当座)');
            $table->integer('bank_account_number')->comment('口座番号');
            $table->string('bank_account_holder')->comment('口座名義');
            // $table->boolean('is_default')->default(0)->comment('0: Not-default, 1: Default');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fiat_withdraw_accounts');
    }
}
