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
        Schema::create('withdraws', function (Blueprint $table) {
            $table->char('id', 36)->default('uuid()')->primary();
            $table->string('order_id')->nullable();
            $table->char('merchant_store_id', 36)->comment('加盟店ID');
            $table->char('admin_approve_id', 36)->nullable();
            $table->enum('withdraw_method', ['cash', 'banking', 'crypto'])->comment('支払い先情報');
            $table->enum('withdraw_request_method', ['manual', 'auto'])->default('manual')->comment('発行元');
            $table->enum('withdraw_status', ['waiting_approve', 'processing', 'denied', 'succeeded'])->default('waiting_approve')->comment('ステータス');
            $table->decimal('amount', 15);
            $table->string('asset', 10);
            $table->decimal('fee', 15);
            $table->string('fee_asset', 10);
            $table->string('hash')->nullable();
            // $table->char('fiat_withdraw_account_id', 36)->nullable();
            // $table->char('crypto_withdraw_account_id', 36)->nullable();
            $table->json('bank_info')->nullable();
            $table->json('crypto_info')->nullable();
            $table->dateTime('approve_datetime')->nullable();
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
        Schema::dropIfExists('withdraws');
    }
};
