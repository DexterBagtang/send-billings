<?php

namespace App\Jobs;

use App\Mail\ResendMail;
use App\Models\File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Redis;

class ResendJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $subject;
    protected $file;
    protected $data;
    protected $billId;




    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email,$file,$subject,$data,$billId)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->file = $file;
        $this->data = $data;
        $this->billId = $billId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file = File::query()
            ->where('id','=',$this->billId)
            ->first();
        $file->emailStatus = "sending error";
        $file->emailDate = now();
        $file->update();

        Mail::to($this->email)
            ->send(new ResendMail($this->file,$this->subject,$this->data));

        $file = File::query()
            ->where('id','=',$this->billId)
            ->first();
        $file->emailStatus = "sent";
        $file->emailDate = now();
        $file->update();

        sleep(30);

    }
}
