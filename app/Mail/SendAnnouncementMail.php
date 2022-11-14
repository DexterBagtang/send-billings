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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fileNames,$data)
    {
        $this->fileNames = $fileNames;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->view('emails.announcementFormat',$this->data)->subject('Test subject');
        foreach ($this->fileNames as $fileName) {
            $attachment = public_path("announcement/$fileName");
            $email->attach($attachment);
        }
        return $email;
    }
}
