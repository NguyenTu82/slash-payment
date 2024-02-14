<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_success', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary()->comment('受信通知ID');
            $table->char('transaction_history_id', 36);
            $table->char('merchant_store_id', 36);
            $table->decimal('payment_amount', 15);
            $table->string('payment_asset', 10);
            $table->decimal('received_amount', 15);
            $table->string('received_asset', 10);
            $table->string('network');
            $table->enum('request_method', ['from_user', 'from_merchant']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_success');
    }
};
