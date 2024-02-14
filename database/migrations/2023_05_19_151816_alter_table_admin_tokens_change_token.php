<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAdminTokensChangeToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_tokens', function (Blueprint $table) {
            $table->string('token', 255)->nullable()->comment('トークン')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_tokens', function (Blueprint $table) {
            $table->string('token', 10)->nullable()->comment('トークン')->change();
        });
    }
}
