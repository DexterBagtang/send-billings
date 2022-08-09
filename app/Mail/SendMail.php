<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $file;
    public $subject;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($file,$subject)
    {
        $this->file = $file;
        $this->subject = $subject;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.billingFormat')
            ->subject($this->subject)
            ->attach($this->file);
    }
}
