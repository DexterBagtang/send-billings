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
    public $subject;
    public $data;



    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($file,$subject,$data)
    {
        $this->file  = $file;
        $this->subject = $subject;
        $this->data = $data;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = "Statement of Account";
        return $this->view('emails.billingFormat', $this->data)
            ->subject($this->subject)
            ->attach($this->file,[
                'as' => "$name.pdf",
                'mime' => 'application/pdf',
            ]);
    }
}
