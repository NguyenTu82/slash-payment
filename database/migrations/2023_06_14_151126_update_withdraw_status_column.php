<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateWithdrawStatusColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE withdraws MODIFY COLUMN withdraw_status ENUM('waiting_approve', 'tgw_waiting_approve', 'denied', 'succeeded') DEFAULT 'waiting_approve'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE withdraws MODIFY COLUMN withdraw_status ENUM('waiting_approve', 'processing', 'denied', 'succeeded') DEFAULT 'waiting_approve'");
    }
}
