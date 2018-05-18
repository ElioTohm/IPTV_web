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
use App\Catchup;

class CatchUp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $STREAM_ID;
    protected $process;

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
        $logpath = env('HOME_ENV_PATH') .'/storage/log/worker.log';
        $exec_file = env('HOME_ENV_PATH') . 'hls-stream.sh';
        $pid = exec('bash ' . $exec_file . ' ' . $stream->vid_stream .  '?fifo_size=1000000 ' . $stream->id . ' '. intdiv(env('DURATION_CATCHUP'), 60). ' '. env('HOME_ENV_PATH').'/storage/app/public/store/streams');
        // $this->process = new Process('bash ' . $exec_file . ' ' . $stream->vid_stream .  '?fifo_size=1000000 ' . $stream->id . ' '. intdiv(env('DURATION_CATCHUP'), 60). ' '. env('HOME_ENV_PATH').'/storage/app/public/store/streams');
        // $this->process->run();
    }

}
