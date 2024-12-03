<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RepairStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $repairDetails;

    /**
     * Create a new message instance.
     *
     * @param $repairDetails
     */
    public function __construct($repairDetails)
    {
        $this->repairDetails = $repairDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.repair_status_notification')
            ->subject('แจ้งเตือนสถานะการซ่อม')
            ->with([
                'repairDetails' => $this->repairDetails,
            ]);
    }
}
