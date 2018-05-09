<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Storage;
use App\Stream;

class CatchUp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 0;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 0;

    protected $STREAM_ID;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($stream_id)
    {
        $this->STREAM_ID = $stream_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stream = Stream::find($this->STREAM_ID);
        $exec_file = env('HOME_ENV_PATH') . 'hls-stream.sh';
        $process = new Process('bash ' . $exec_file . ' ' . $stream->vid_stream .  '?fifo_size=1000000 ' . $stream->id . ' 8640');
        $process->run();
        
        // while ($process->isRunning()) {
        //     // waiting for process to finish
        // }
        
        echo $process->getOutput();        
    }
}
