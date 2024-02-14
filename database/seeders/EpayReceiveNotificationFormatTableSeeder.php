<?php

namespace Database\Seeders;

use App\Models\MerchantGroup;
use App\Models\MerchantUser;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class epayReceiveNotificationFormatTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        DB::table('epay_receive_notification_format')->updateOrInsert(
            ['from_type' => 'from_epay'],
            [
                'id' => $faker->uuid,
                'content' => '<p>いつもepayをご利用頂き、誠にありがとうございます。</p> <p>「{{merchant_name}}」様からの出金リクエストを受付完了致しましたのでご報告いたします。</p><p>内容：{{request_content}}</p><p>金額：{{amount}}円</p><p>方法：{{type}}</p><p><br></p>',
                'created_at' => NULL,
                'updated_at' => '2023-06-16 10:48:51',
                'deleted_at' => NULL,
                'title' => '出金リクエスト受付通知',
                'type' => 'withdrawal_accepted',
                'from_type' => 'from_epay'
            ]
        );
    }
}
