<?php

namespace App\Jobs;

use App\Mail\SendAnnouncementMail;
use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendAnnouncementJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;
    protected $subject;
    protected $id;
    protected $email;
    protected $fileNames;



    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$subject,$id,$email,$fileNames)
    {
        $this->data = $data;
        $this->subject = $subject;
        $this->id = $id;
        $this->email = $email;
        $this->fileNames = $fileNames;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $announcement = Announcement::query()->where('id','=',$this->id)->first();
//        $announcement = Announcement::find($this->id);
        $announcement->emailStatus = "Sending Error";
        $announcement->emailDate = now();
        $announcement->update();

        Mail::mailer('smtp2')->to('Dexter.Bagtang@philcom.com')
            ->send(new SendAnnouncementMail($this->fileNames,$this->data,$this->subject));

        $announcement = Announcement::query()->where('id','=',$this->id)->first();
        $announcement->emailStatus = "Sent";
        $announcement->emailDate = now();
        $announcement->update();
    }
}
