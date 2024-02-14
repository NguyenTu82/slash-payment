<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnToEpayReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('epay_reports', function (Blueprint $table) {
            $table->dropColumn('transaction_number');
            $table->dropColumn('transaction_amount');
            $table->dropColumn('planned_withdrawal_amount');
            $table->dropColumn('withdrew_amount');
            $table->dropColumn('withdraw_fee');

            $table->json('payment_amount')->comment('取引金額')->nullable();
            $table->json('received_amount')->comment('受付金額')->nullable();
            $table->json('withdraw_amount')->comment('出金額')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('epay_reports', function (Blueprint $table) {
            $table->integer('transaction_number')->comment('トランザクション数');
            $table->decimal('transaction_amount', 15)->comment('取引金額');
            $table->decimal('planned_withdrawal_amount', 15)->comment('出金予定額');
            $table->decimal('withdrew_amount', 15)->comment('出金済額');
            $table->decimal('withdraw_fee', 15)->comment('出金手数料');

            $table->dropColumn('payment_amount');
            $table->dropColumn('received_amount');
            $table->dropColumn('withdraw_amount');
        });
    }
}