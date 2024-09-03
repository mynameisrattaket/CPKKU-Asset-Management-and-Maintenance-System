<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;

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
                        'requestRepairAt' => Carbon::now('Asia/Bangkok')->format('Y-m-d H:i:s'),
                    ]);
    }


}
