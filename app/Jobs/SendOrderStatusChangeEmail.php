<?php

namespace App\Jobs;

use App\Mail\ChangeOrderStatusMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOrderStatusChangeEmail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $order;
    protected $userEmail;
    protected $senderEmail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order, $userEmail, $senderEmail = null)
    {
        $this->order = $order;
        $this->userEmail = $userEmail;
        $this->senderEmail = $senderEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->userEmail)->send(new ChangeOrderStatusMail($this->order, $this->senderEmail));
    }
}
