<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\EpayReportType;

class UpdateColumnTypeToEpayReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('epay_reports', function (Blueprint $table) {
            $table->integer('type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('epay_reports', function (Blueprint $table) {
            $table->enum('type', [
                EpayReportType::DAILY->value,
                EpayReportType::WEEKLY->value,
                EpayReportType::MONTHLY->value,
                EpayReportType::EVERY_PAYMENT_CIRCLE->value,
            ]);
        });
    }
}