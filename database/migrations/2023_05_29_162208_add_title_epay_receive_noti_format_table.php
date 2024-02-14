<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleEpayReceiveNotiFormatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('epay_receive_notification_format', function (Blueprint $table) {
            $table->string('title', 255)->comment('タイトル');
            $table->enum('type', [
                \App\Enums\NotiTypeReceive::NEW_REGISTER->value,
                \App\Enums\NotiTypeReceive::WITHDRAWAL->value,
                \App\Enums\NotiTypeReceive::CANCEL->value,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('epay_receive_notification_format', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('type');
        });
    }
}
