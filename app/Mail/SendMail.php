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
//        $files[] = $this->file  ;
        foreach ($this->attachment as $name){
            $attachment = public_path("attachments/$name");
            $files[] = $attachment;
        }
//        $files = [$this->file,$this->attachment];
        $name = "Statement of Account";
        $email = $this->view('emails.billingFormat', $this->data)->subject($this->subject);

        $email->attach($this->file,[
        'as' => "$name.pdf",
        'mime' => 'application/pdf',
        ]);
        foreach ($files as $file){
            $email->attach($file);
        }
        return $email;
//            ->from('no-reply@philcom.com','no-reply')





    }
}
