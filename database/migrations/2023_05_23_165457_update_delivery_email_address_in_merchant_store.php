<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDeliveryEmailAddressInMerchantStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_stores', function (Blueprint $table) {
            $table->dropColumn('delivery_email_address');
            $table->string('delivery_email_address1', 255)->nullable()->comment('配信メールアドレス1');
            $table->string('delivery_email_address2', 255)->nullable()->comment('配信メールアドレス2');
            $table->string('delivery_email_address3', 255)->nullable()->comment('配信メールアドレス3');
            $table->string('ship_post_code_id', 25)->nullable()->comment('発送先郵便番号');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('merchant_stores', function (Blueprint $table) {
            $table->string('delivery_email_address', 255)->nullable()->comment('配信メールアドレス');
            $table->dropColumn('delivery_email_address1');
            $table->dropColumn('delivery_email_address2');
            $table->dropColumn('delivery_email_address3');
            $table->dropColumn('ship_post_code_id');
        });
    }
}
