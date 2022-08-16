<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $file;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($file)
    {
        $this->file  = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.resend')
            ->attach($this->file);
    }
}
