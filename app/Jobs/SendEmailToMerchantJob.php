<?php

namespace App\Jobs;

use App\Mail\Notification;
use App\Repositories\MerchantNotificationRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailToMerchantJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var array<mixed> */
    protected $data;

    /**
     * __construct
     *
     * @param mixed $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->data['toEmail'])->send(new Notification($this->data['content'], $this->data['title']));
        $merchantNotificationRepo = app()->make(MerchantNotificationRepository::class);
        $merchantNotificationRepo->create($this->data['merchantReceiveNotiData']);
    }
}
