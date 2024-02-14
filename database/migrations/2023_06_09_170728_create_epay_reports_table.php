<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use App\Enums\EpayReportType;

class CreateEpayReportsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('epay_reports', function(Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary()->comment('ID');
            $table->string('merchant_store_id', 255)->comment('加盟店ID');
            $table->string('report_code', 255)->comment('報告コード');
            $table->dateTime('period_from')->comment('期間〜');
            $table->dateTime('period_to')->comment('〜期間');
            $table->dateTime('issue_date')->comment('発行日');
            $table->tinyinteger('status')->comment('(0:送信前, 1: 送信済)')->default(0);
            $table->enum('type', [
                EpayReportType::DAILY->value,
                EpayReportType::WEEKLY->value,
                EpayReportType::MONTHLY->value,
                EpayReportType::EVERY_PAYMENT_CIRCLE->value,
            ]);

            $table->string('send_email', 255)->comment('メール');
            $table->integer('transaction_number')->comment('トランザクション数');
            $table->decimal('transaction_amount', 15)->comment('取引金額');
            $table->decimal('planned_withdrawal_amount', 15)->comment('出金予定額');
            $table->decimal('withdrew_amount', 15)->comment('出金済額');
            $table->decimal('withdraw_fee', 15)->comment('出金手数料');
            $table->text('note')->nullable()->comment("内容");
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
		Schema::dropIfExists('epay_reports');
	}
};
