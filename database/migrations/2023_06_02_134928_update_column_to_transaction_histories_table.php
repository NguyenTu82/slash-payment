<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateColumnToTransactionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_histories', function (Blueprint $table) {
            $table->datetime('payment_succes_datetime')->comment('支払い成功日時')->nullable()->change();
            $table->datetime('payment_due_datetime')->comment('支払日 時')->nullable()->change();
            $table->text('callback_logs')->comment('コールバック ログ')->nullable()->change();
        });
        DB::statement("ALTER TABLE transaction_histories MODIFY request_method ENUM('from_user', 'from_merchant') NOT NULL");
        DB::statement("ALTER TABLE transaction_histories MODIFY payment_status ENUM('requested', 'success', 'cancelled') NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_histories', function (Blueprint $table) {
            $table->datetime('payment_succes_datetime')->comment('支払い成功日時');
            $table->datetime('payment_due_datetime')->comment('支払日 時');
            $table->text('callback_logs')->comment('コールバック ログ');
            $table->tinyInteger('request_method')->comment('リクエスト方式（エンド/加盟店）');
            $table->tinyInteger('payment_status')->comment('決済ステータス (完了/失敗/未決済)');
        });
    }
}