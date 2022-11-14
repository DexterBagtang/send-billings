<?php

namespace App\Jobs;

use App\Mail\SendAnnouncementMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAnnouncementJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;
    protected $id;
    protected $email;
    protected $fileNames;



    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$id,$email,$fileNames)
    {
        $this->data = $data;
        $this->email = $email;
        $this->id = $id;
        $this->fileNames = $fileNames;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to('Dexter.Bagtang@philcom.com')
            ->send(new SendAnnouncementMail($this->fileNames,$this->data,));
    }
}
