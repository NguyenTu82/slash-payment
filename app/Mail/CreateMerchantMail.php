<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateMerchantMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject(__("加盟店の仮登録完了のご連絡"))->view(
            "epay.emails.create_merchant",
            $this->data
        );
    }
}
