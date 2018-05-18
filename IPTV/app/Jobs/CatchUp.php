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
use App\JobProcess;

class CatchUp implements ShouldQueue
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
        $stream = Stream::find($this->CHANNEL->stream->id);
        $stream->catchup = true;
        $stream->save();
        // $logpath = env('HOME_ENV_PATH') .'/storage/log/worker.log';
        // $exec_file = env('HOME_ENV_PATH') . 'hls-stream.sh';
        // $executable = 'bash ' . $exec_file . ' ' . $stream->vid_stream .  '?fifo_size=1000000 ' . $stream->id . ' '. intdiv(env('DURATION_CATCHUP'), 60). ' '. env('HOME_ENV_PATH').'/storage/app/public/store/streams';
        $path = env('HOME_ENV_PATH').'/storage/app/public/store/streams';
        $cmd = " -codec copy -map 0:v -map 0:a  -hls_time 10 -hls_list_size 6 -hls_flags delete_segments -hls_segment_filename $path/$stream->id/$stream->id_%03d.ts $path/$stream->id/master.m3u8";
        exec('nohup /home/user/bin/ffmpeg -re -hide_banner -y -hwaccel auto -vsync 0 -stream_loop -1 -i '.$stream->vid_stream.'?fifo_size=1000000 '.$cmd.' </dev/null >/dev/null 2>/var/log/ffmpeg-'. $stream->id .'.log  & echo $!', $op);

        $process = new JobProcess();
        $process->pid = $op[0];
        $process->name = $this->CHANNEL->name;
        $process->stream = $stream->vid_stream;
        $process->log =' var/log/ffmpeg-'. $stream->id .'.log';
        $process->command = 'catchup';        
        $process->save();
    }

}
