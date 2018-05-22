<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use App\Stream;
use App\JobProcess;


class StreamPassThrough implements ShouldQueue
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

        // create dir for stream
        $path = env('HOME_ENV_PATH').'/storage/app/public/store/streams';
        Storage::makeDirectory('/public/store/streams/' . $stream->id);
        
        // ffmpeg parameters for command
        $hls_time = 1;
        $hls_list_size = 5;
        $header_cmd = '-re -hide_banner -y -hwaccel auto -stream_loop -1';
        $tail_cmd = "</dev/null >/dev/null 2>". env('HOME_ENV_PATH') ."/storage/logs/ffmpeg-$stream->id.log & echo $!";
        $cmd = " -ignore_unknown -codec copy -map 0:v -map 0:a -hls_allow_cache 0  -hls_list_size $hls_list_size -hls_list_size $hls_list_size -hls_flags delete_segments -hls_segment_filename $path/$stream->id/$stream->id_%03d.ts $path/$stream->id/master.m3u8";

        // execute command as no hop and add echo $! to get pid of process
        exec("/home/".env('USER')."/bin/ffmpeg $header_cmd  -i \"$stream->vid_stream?overrun_nonfatal=1&fifo_size=100000\" $cmd", $op);
        
        // save information of the process
        $process = new JobProcess();
        $process->pid = $op[0];
        $process->name = $this->CHANNEL->name;
        $process->stream = $stream->vid_stream;
        $process->log ='/var/log/ffmpeg-'. $stream->id .'.log';
        $process->command = 'StreamPassThrough';        
        $process->save();
    }

}
