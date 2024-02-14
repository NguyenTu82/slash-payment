<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnToSlashApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slash_apis', function (Blueprint $table) {
            DB::statement("ALTER TABLE slash_apis MODIFY receive_crypto_type ENUM('USDT', 'USDC', 'DAI', 'JPYC') NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slash_apis', function (Blueprint $table) {
            $table->tinyinteger('receive_crypto_type')->nullable()->comment('(0: USDT, 1: USDC, 2: DAI, 3: JPYC)');
        });
    }
}
