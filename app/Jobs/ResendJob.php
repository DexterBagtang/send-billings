<?php

namespace App\Jobs;

use App\Mail\ResendMail;
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
    protected $file;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email,$file)
    {
        $this->email = $email;
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        Redis::throttle('resend')->block(0)->allow(2)->every(5)->then(function (){
//            info("lock obtained");


            Mail::to('Dexter.Bagtang@philcom.com')
                ->send(new ResendMail($this->file));
        sleep(1);


//        },function (){
//            return $this->release(5);
//        });
    }
}
