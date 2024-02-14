<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEpaySendNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('epay_send_notification', function (Blueprint $table) {
            $table->text('merchant_receive_list')->nullable()->comment('加盟店IDリスト')->change();
            $table->string('title', 255)->comment('タイトル')->change();
            $table->text('content')->comment('内容')->change();
            $table->smallInteger('type')->comment('(0:加盟店全部通知, 1: 加盟店一部通知)')->change();
            $table->smallInteger('status')->comment('(0:未読, 1:既読)')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('epay_send_notification', function (Blueprint $table) {
            $table->string('merchant_receive_list', 255)->nullable()->comment('加盟店IDリスト')->change();
            $table->string('title', 255)->nullable()->comment('タイトル')->change();
            $table->string('content', 255)->comment('内容')->change();
            $table->tinyinteger('type')->nullable()->comment('(0:加盟店全部通知, 1: 加盟店一部通知)')->change();
            $table->tinyinteger('status')->nullable()->comment('(0:未読, 1:既読)')->default(0)->change();
        });
    }
}
