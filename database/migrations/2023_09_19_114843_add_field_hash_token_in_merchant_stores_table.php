<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldHashTokenInMerchantStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE merchant_stores MODIFY COLUMN api_key VARCHAR(255) DEFAULT NULL COMMENT 'APIキー(認証コード)'");
        DB::statement("ALTER TABLE merchant_stores MODIFY COLUMN withdraw_method ENUM('cash', 'banking', 'crypto') DEFAULT NULL");

        Schema::table('merchant_stores', function (Blueprint $table) {
            $table->string('hash_token', 255)->comment('APIキー(ハッシュトークン)')->nullable()->unique()->after('api_key');
            $table->renameColumn('api_key', 'auth_token');
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
            $table->dropColumn('hash_token');
            $table->renameColumn('auth_token', 'api_key');
        });
        DB::statement("ALTER TABLE merchant_stores MODIFY COLUMN api_key VARCHAR(255) NOT NULL COMMENT 'APIキー'");
        DB::statement("ALTER TABLE merchant_stores MODIFY COLUMN withdraw_method ENUM('cash', 'banking', 'crypto') NOT NULL");
    }
}
