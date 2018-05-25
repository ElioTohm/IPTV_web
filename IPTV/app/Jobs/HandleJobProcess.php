<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\JobProcess;
use Illuminate\Support\Facades\Storage;

class HandleJobProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $CHANNEL;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($channel)
    {
        $this->CHANNEL = $channel;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $jobprocess = JobProcess::where('name', $this->CHANNEL->name)->first();
        exec("kill -15 $jobprocess->pid");  
        $path = env('HOME_ENV_PATH').'/storage/app/public/store/streams';
        Storage::deleteDirectory("/public/store/streams/". $this->CHANNEL->stream->id);
        $jobprocess->delete();
    }
}
