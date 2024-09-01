<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RepairRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $repairDetails;
    public $technician;
    public $reporter;

    public function __construct($repairDetails, $technician, $reporter)
    {
        $this->repairDetails = $repairDetails;
        $this->technician = $technician;
        $this->reporter = $reporter;
    }

    public function build()
    {
        return $this->view('emails.repair_notification')
                    ->subject('แจ้งเตือนการแจ้งซ่อมใหม่')
                    ->with([
                        'repairDetails' => $this->repairDetails,
                        'technician' => $this->technician,
                        'reporter' => $this->reporter,
                    ]);
    }
}
