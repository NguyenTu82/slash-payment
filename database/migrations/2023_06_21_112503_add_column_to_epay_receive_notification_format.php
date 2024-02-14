<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToEpayReceiveNotificationFormat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('epay_receive_notification_format', function (Blueprint $table) {
            $table->enum('from_type', ['from_user', 'from_epay'])->default('from_user')->after('type');;
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
            $table->dropColumn('from_type');
        });
    }
}
