<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_histories', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary()->comment('ID');
            $table->uuid('merchant_store_id')->comment('加盟店ID');
            $table->datetime('transaction_date')->comment('日時（JST）');
            $table->decimal('payment_amount', 10, 2)->comment('支払金額');
            $table->string('payment_asset', 100)->comment('支払資産');
            $table->decimal('received_amount', 10, 2)->comment('受取額');
            $table->string('received_asset', 100)->comment('受取資産');
            $table->string('network', 255)->comment('ネットワーク');
            $table->tinyInteger('request_method')->comment('リクエスト方式（エンド/加盟店）');
            $table->tinyInteger('payment_status')->comment('決済ステータス (完了/失敗/未決済)');
            $table->datetime('payment_succes_datetime')->comment('支払い成功日時');
            $table->datetime('payment_due_datetime')->comment('支払日 時');
            $table->string('hash', 255)->comment('Hash');
            $table->string('order_code', 255)->comment('オーダーコード');
            $table->text('callback_logs')->comment('コールバック ログ');
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
        Schema::dropIfExists('transaction_histories');
    }
}
