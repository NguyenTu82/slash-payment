<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use \App\Enums\MerchantUserStatus;

class CreateTblMerchantUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_users', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary()->comment('ID');
            $table->uuid('merchant_role_id')->comment('権限ID');
            $table->string('name', 255)->comment('管理者名');
            $table->string('email', 255)->comment('メール');
            $table->tinyInteger('status')->default(MerchantUserStatus::VALID->value)->comment('0: 有効、1: 無効');
            $table->uuid('parent_user_id')->nullable()->default(null)->comment('上司ID');
            $table->datetime('email_verified_at')->nullable()->default(null)
                ->comment('メール認証日時');
            $table->string('phone', 20)->nullable()->default(null)->comment('電話番号');
            $table->string('password', 255)->nullable()->default(null)
                ->comment('パスワード');
            $table->string('remember_token', 100)->nullable()->default(null)
                ->comment('記憶トークン');
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER Table merchant_users add user_code INTEGER NOT NULL UNIQUE AUTO_INCREMENT;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchant_users');
    }
}
