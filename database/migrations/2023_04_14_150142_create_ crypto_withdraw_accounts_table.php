<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoWithdrawAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_withdraw_accounts', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary()->comment('ID');
            $table->uuid('merchant_store_id')->comment('加盟店ID');
            $table->string('asset', 100)->nullable()->comment('資産');
            $table->string('network', 255)->comment('ネットワーク (ECR/TRC/… )');
            $table->string('wallet_address', 255)->comment('Wallet address');
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
        Schema::dropIfExists('crypto_withdraw_accounts');
    }
}
