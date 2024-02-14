<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNameColumnToTransactionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_histories', function (Blueprint $table) {
            $table->renameColumn('payment_succes_datetime', 'payment_success_datetime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_histories', function (Blueprint $table) {
            $table->renameColumn('payment_success_datetime', 'payment_succes_datetime');
        });
    }
}
