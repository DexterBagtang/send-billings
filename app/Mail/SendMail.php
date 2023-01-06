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
    public $attachment;
//    public $message;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($file,$subject,$data,$attachment)
    {
        $this->file = $file;
        $this->subject = $subject;
        $this->data = $data;
        $this->attachment= $attachment;
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
        $email = $this->view('emails.billingFormat', $this->data)
            ->subject($this->subject)
            ->bcc('Dexter.Bagtang@philcom.com');

        $email->attach($this->file,[
            'as' => "$name.pdf",
            'mime' => 'application/pdf',
        ]);
//        $files[] = $this->file  ;
        if ($this->attachment != [null]){
            foreach ($this->attachment as $name){
                $attachment = public_path("attachments/$name");
                $email->attach($attachment);
            }
        }
//        $files = [$this->file,$this->attachment];


        return $email;
//            ->from('no-reply@philcom.com','no-reply')





    }
}
