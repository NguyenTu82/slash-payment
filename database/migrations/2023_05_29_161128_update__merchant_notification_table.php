<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMerchantNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_notification', function (Blueprint $table) {
            $table->uuid('epay_sent_noti_id')->comment('epay通知ID');;
            $table->datetime('send_date')->comment('受信日時')->change();
            $table->string('title', 255)->comment('タイトル')->change();
            $table->text('content')->comment('内容')->change();
            $table->smallInteger('type')->comment('(0:出金通知, 1: epayからのご通知)')->change();
            $table->smallInteger('status')->comment('(0:未読, 1: 既読)')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('merchant_notification', function (Blueprint $table) {
            $table->dropColumn('epay_sent_noti_id');
            $table->datetime('send_date')->nullable()->comment('受信日時')->change();
            $table->string('title', 255)->nullable()->comment('タイトル')->change();
            $table->string('content', 255)->nullable()->comment('内容')->change();
            $table->tinyinteger('type')->nullable()->comment('(0:出金通知, 1: epayからのご通知)')->change();
            $table->tinyinteger('status')->nullable()->comment('(0:未読, 1: 既読)')->default(0)->change();
            
        });
    }
}
