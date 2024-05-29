<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangeOrderStatusMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $order;
    public $senderEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $senderEmail = null)
    {
        $this->order = $order;
        $this->senderEmail = $senderEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.order_change')
            ->subject(trans('order.subject'))
            ->from(config('constant.email_sender'))
            ->with(['order' => $this->order]);
    }
}
