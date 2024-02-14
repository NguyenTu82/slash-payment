<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpaySendNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('epay_send_notification', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary()->comment('受信通知ID');
            $table->string('merchant_receive_list', 255)->nullable()->comment('加盟店IDリスト');
            $table->datetime('schedule_send_date')->nullable()->comment('送信予定日時');
            $table->datetime('actual_send_date')->nullable()->comment('送信済日時');
            $table->string('title', 255)->nullable()->comment('タイトル');
            $table->string('content', 255)->nullable()->comment('内容');
            $table->tinyinteger('type')->nullable()->comment('(0:加盟店全部通知, 1: 加盟店一部通知)');
            $table->tinyinteger('status')->nullable()->comment('(0:未読, 1:既読)')->default(0);
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
        Schema::dropIfExists('epay_send_notification');
    }
}
