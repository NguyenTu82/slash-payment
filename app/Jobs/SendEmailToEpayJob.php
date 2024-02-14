<?php

namespace App\Jobs;

use App\Mail\Notification;
use App\Repositories\AdminRepositoryInterface;
use App\Repositories\EpayReceiveNotiRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailToEpayJob implements ShouldQueue
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
        // insert data to epay_receive_notification
        $epayReceiveNotiRepo = app()->make(EpayReceiveNotiRepository::class);
        $epayReceiveNotiRepo->create($this->data['epayReceiveNotiData']);

        // send mail to one by one admin epay
        $adminRepo = app()->make(AdminRepositoryInterface::class);
        $admins = $adminRepo->getAdmins();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new Notification($this->data['content'], $this->data['title']));
        }
    }
}
