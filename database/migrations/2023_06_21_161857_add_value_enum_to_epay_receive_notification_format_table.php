<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValueEnumToEpayReceiveNotificationFormatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("ALTER TABLE epay_receive_notification_format MODIFY type ENUM('new_merchant', 'withdrawal', 'merchant_cancel', 'withdrawal_accepted')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('epay_receive_notification_format', function (Blueprint $table) {
            $table->enum('type', ['new_merchant', 'withdrawal', 'merchant_cancel']);
        });
    }
}
