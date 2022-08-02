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
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $email;
    protected $file;
    protected $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email,$file,$id)
    {
        $this->email = $email;
        $this->file = $file;
        $this->id = $id;
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
        $file->update();


        Mail::to($this->email)
            ->send(new SendMail($this->file));

        $file = File::query()
//            ->where('email','=',$this->email)
            ->where('id','=',$this->id)
            ->first();
        $file->emailStatus = "sent";
        $file->emailDate = now();
        $file->update();
    }
}
