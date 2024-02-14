<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class Notification extends Mailable
{
    use Queueable;
    use SerializesModels;

    private $content;
    private $title;

    public function __construct($content,$title)
    {
        $this->content = $content;
        $this->title = $title;
    }

    public function build()
    {
        return $this->subject(__($this->title))->view(
            "common.emails.email",
            ["content" => $this->content]
        );
    }
}
