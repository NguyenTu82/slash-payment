<?php

namespace App\Mail\Merchant;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var array<mixed> */
    protected $data;

    /**
     * __construct
     *
     * @param  mixed $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $lang = $this->data['language'] ?? 'ja';
        $view = "merchant.emails.$lang.reset_password";

        return $this->view($view)
            ->subject( __('auth.merchant.reset_password', [], $lang))
            ->with([
                'email' => $this->data['email'],
                'url' => $this->data['url'],
            ]);
    }
}
