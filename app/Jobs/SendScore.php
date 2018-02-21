<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Mail;

class SendScore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $string;
    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($string, $email)
    {
        $this->string = $string;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        Log::info('Hello, Redis-Queue' . $this->string['school']);
        Mail::to($this->email)->send(new \App\Mail\SendScore($this->string));
    }
}
