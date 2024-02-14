<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlashApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slash_apis', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary()->comment('ID');
            $table->string('merchant_store_id', 255)->nullable()->comment('加盟店ID');
            $table->string('contract_wallet', 255)->nullable()->comment('コントラクトウォレット');
            $table->string('receive_wallet_address', 255)->nullable()->comment('受取ウォレットアドレス');
            $table->tinyinteger('receive_crypto_type')->nullable()->comment('(0: USDT, 1: USDC, 2: DAI, 3: JPYC)');
            $table->string('slash_auth_token', 255)->nullable()->comment('SLASH認証トークン');
            $table->string('slash_hash_token', 255)->nullable()->comment('SLASHハッシュトークン');
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
        Schema::dropIfExists('slash_apis');
    }
}
