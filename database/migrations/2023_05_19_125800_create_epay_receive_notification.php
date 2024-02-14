<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpayReceiveNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('epay_receive_notification', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary()->comment('加盟店通知ID');
            $table->uuid('merchant_id')->comment('加盟店ID');
            $table->uuid('format_type_id')->comment('フォーマットID');
            $table->datetime('send_date')->comment('受信日時');
            $table->string('title', 255)->comment('タイトル');
            $table->text('content')->comment('内容');
            $table->enum('type', [
                \App\Enums\NotiTypeReceive::NEW_REGISTER->value,
                \App\Enums\NotiTypeReceive::WITHDRAWAL->value,
                \App\Enums\NotiTypeReceive::CANCEL->value,
            ]);
            $table->tinyinteger('status')->comment('(0:未読, 1: 既読)')->default(0);
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
        Schema::dropIfExists('epay_receive_notification');
    }
}
