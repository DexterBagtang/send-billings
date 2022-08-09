<?php

namespace App\Jobs;

use App\Mail\SendMail;
use App\Models\File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $email;
    protected $file;
    protected $id;
    protected $cc;
    protected $bcc;
    protected $subject;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email,$file,$id,$cc,$bcc,$subject)
    {
        $this->email = $email;
        $this->file = $file;
        $this->id = $id;
        $this->cc = $cc;
        $this->bcc = $bcc;
        $this->subject = $subject;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file = File::query()
//            ->where('email','=',$this->email)
            ->where('id','=',$this->id)
            ->first();
        $file->emailStatus = "sending error";
        $file->emailDate = now();
//        $file->emailedBy = Auth::user()->name;
        $file->update();


        Mail::to(/*$this->email*/'Dexter.Bagtang@philcom.com')
            ->cc($this->cc)
            ->bcc($this->bcc)
            ->send(new SendMail($this->file,$this->subject.' '.$this->email));

        $file = File::query()
//            ->where('email','=',$this->email)
            ->where('id','=',$this->id)
            ->first();
        $file->emailStatus = "sent";
        $file->emailDate = now();
//        $file->emailedBy = auth()->user()->name;
        $file->update();
    }
}
