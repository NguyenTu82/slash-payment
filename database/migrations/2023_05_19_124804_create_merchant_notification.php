<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_notification', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary()->comment('加盟店通知ID');
            $table->uuid('merchant_id')->comment('加盟店ID');
            $table->datetime('send_date')->nullable()->comment('受信日時');
            $table->string('title', 255)->nullable()->comment('タイトル');
            $table->string('content', 255)->nullable()->comment('内容');
            $table->tinyinteger('type')->nullable()->comment('(0:出金通知, 1: epayからのご通知)');
            $table->tinyinteger('status')->nullable()->comment('(0:未読, 1: 既読)')->default(0);
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
        Schema::dropIfExists('merchant_notification');
    }
}
