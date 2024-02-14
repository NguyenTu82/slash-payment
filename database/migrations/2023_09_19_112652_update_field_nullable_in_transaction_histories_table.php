<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFieldNullableInTransactionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_histories', function (Blueprint $table) {
            $table->decimal('payment_amount', 10, 2)->nullable()->change();
            $table->string('payment_asset', 100)->nullable()->change();
            $table->decimal('received_amount', 10, 2)->nullable()->change();
            $table->string('received_asset', 100)->nullable()->change();
            $table->string('network', 255)->nullable()->change();
            $table->string('hash', 255)->nullable()->change();
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
            $table->decimal('payment_amount', 10, 2)->nullable(false)->change();
            $table->string('payment_asset', 100)->nullable(false)->change();
            $table->decimal('received_amount', 10, 2)->nullable(false)->change();
            $table->string('received_asset', 100)->nullable(false)->change();
            $table->string('network', 255)->nullable(false)->change();
            $table->string('hash', 255)->nullable(false)->change();
        });
    }
}
