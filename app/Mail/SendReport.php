<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Storage;

class SendReport extends Mailable
{
    use Queueable, SerializesModels;

    private $data;
    private $pdfFilePath;
    private $pdfFileName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $pdfFilePath, $pdfFileName)
    {
        $this->data = $data;
        $this->pdfFilePath = $pdfFilePath;
        $this->pdfFileName = $pdfFileName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $attachFilePath = Storage::disk('s3')->get($this->pdfFilePath);
        return $this->subject(__("admin_epay.report.send_report_title"))->view(
            "epay.emails.send_report",
            $this->data
        )->attachData($attachFilePath, $this->pdfFileName);
    }
}
