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
        $exec_file = Storage::url('hls-stream.sh');
        $process = new Process('bash ' . $exec_file . ' ' . $stream->vid_stream . ' ' . $stream->id);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
    }
}
