<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAnnouncementMail extends Mailable
{
    use Queueable, SerializesModels;
    public $fileNames;
    public $data;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fileNames,$data,$subject)
    {
        $this->fileNames = $fileNames;
        $this->data = $data;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->view('emails.announcementFormat',$this->data)->subject($this->subject)->bcc('Dexter.Bagtang@philcom.com');
        if ($this->fileNames !== null){
            foreach ($this->fileNames as $fileName) {
                $attachment = public_path("announcement/$fileName");
                $email->attach($attachment);
            }
        }

        return $email;
    }
}
