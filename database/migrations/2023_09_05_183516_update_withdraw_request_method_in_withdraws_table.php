<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWithdrawRequestMethodInWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE withdraws MODIFY COLUMN withdraw_request_method ENUM('auto', 'request_epay', 'request_merchant') DEFAULT 'request_epay' COMMENT '発行元' ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withdraws', function (Blueprint $table) {
            $table->enum('withdraw_request_method', ['manual', 'auto'])->default('manual')->comment('発行元');
        });
    }
}