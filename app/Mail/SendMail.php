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
    public $data;
//    public $message;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($file,$subject,$data)
    {
        $this->file = $file;
        $this->subject = $subject;
        $this->data = $data;
//        $this->message = $message;

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
            ->from('no-reply@philcom.com','no-reply')
            ->subject($this->subject)
            ->attach($this->file,[
                'as' => "$name.pdf",
                'mime' => 'application/pdf',
            ]);
    }
}
