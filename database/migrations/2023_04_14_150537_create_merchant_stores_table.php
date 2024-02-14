<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_stores', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary()->comment('加盟店ID');
            $table->string('name', 255)->unique()->comment('加盟店名');
            $table->uuid('affiliate_id')->nullable()->comment('AF_ID');
            $table->string('service_name', 255)->nullable()->comment('サービス名');
            $table->string('industry', 255)->nullable()->comment('業種');

            $table->string('representative_name', 255)->nullable()->comment('代表者名');
            $table->tinyinteger('sending_detail')->nullable()->comment('明細送付の有無 (0:無, 1: 有)')->default(0);
            $table->datetime('ship_date')->nullable()->comment('発送日設定');
            $table->string('ship_address', 255)->nullable()->comment('発送先住所');
            $table->string('delivery_email_address', 255)->nullable()->comment('配信メールアドレス');

            $table->tinyinteger('delivery_report')->nullable()->comment('配信レポート選択 (0:トランザクション毎/ 1: Dailyレポー/ 2: Weekly/ 3: Monthly/ 4: 支払いサイクル毎 )');
            $table->tinyinteger('guidance_email')->nullable()->comment('ご案内メール (0: OFF, 1: ON)')->default(1);
            $table->string('api_key', 255)->unique()->default(DB::raw('(UUID())'))->comment('APIキー');
            $table->datetime('contract_date')->nullable()->comment('契約日');
            $table->datetime('termination_date')->nullable()->comment('解約日');

            $table->tinyInteger('status')->default(1)->comment('1:仮登録済, 2:審査中, 3:利用中, 4:停止中, 5:退会, 6:強制退会, 7:契約, 8:削除済');
            $table->decimal('contract_interest_rate', 10, 2)->nullable()->comment('契約利率')->default(0);
            $table->string('payment_cycle', 255)->nullable()->comment('支払いサイクル');
            $table->tinyinteger('payment_currency')->nullable()->comment('支払い方法 (0:銀行振込, 1: 仮想通貨, 2:現金)');
            $table->string('payment_url', 255)->nullable();
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
        Schema::dropIfExists('merchant_stores');
    }
}
