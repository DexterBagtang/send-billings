<?php

namespace App\Jobs;

use App\Mail\SendMail;
use App\Models\File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\SentMessage;
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
    protected $data;
    protected $attachment;

//    protected $message;




    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email,$file,$id,$cc,$bcc,$subject,$data,$attachment)
    {
        $this->email = $email;
        $this->file = $file;
        $this->id = $id;
        $this->cc = $cc;
        $this->bcc = $bcc;
        $this->subject = $subject;
        $this->data = $data;
        $this->attachment = $attachment;

//        $this->message = $message;


    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        $file = File::query()
//            ->where('id','=',$this->id)
//            ->first();
//        $file->emailStatus = "sending error";
//        $file->emailDate = now();
//        $file->update();
//
////        $recipients = str_replace([' ',],'',$this->email);
//
//        Mail::to('Dexter.Bagtang@philcom.com')
////        Mail::to(['Dexter.Bagtang@philcom.com','Lloyd.Torres@philcom.com'])
////      Mail::to('dexterbagtang@gmail.com')
//
//
//            //        Mail::to($recipients)
////            ->cc($this->cc)
////                ->cc('dexterbagtang@gmail.com')
//            ->bcc($this->bcc)
//            ->send(new SendMail($this->file,$this->subject/*.' '.$this->email*/,$this->data,$this->attachment));
//
//        $file = File::query()
//            ->where('id','=',$this->id)
//            ->first();
//        $file->emailStatus = "sent";
//        $file->emailDate = now();
//        $file->update();
        $file = File::query()->where('id','=',$this->id)->first();
        try {

            $recipient = str_replace([' '],'',$this->email);
            $recipients = explode(',',$recipient);
            Mail::to($recipients)
                ->send(new SendMail($this->file,$this->subject/*.' '.$this->email*/,$this->data,$this->attachment));

            $file->emailStatus = "sent";
            $file->emailDate = now();

        }catch (\Exception $e){
            $file->emailStatus = "sending error";
            $file->emailDate = now();

        }
        $file->update();
    }
}
