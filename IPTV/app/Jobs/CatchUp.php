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
    protected $CATCHUP_TIME;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($channel, $catchup_time)
    {
        $this->CHANNEL = $channel;
        $this->CATCHUP_TIME = $catchup_time;
    }

    /**
     * Start ffmpeg process
     *
     * @return void
     */
    public function handle()
    {
        $stream = Stream::find($this->CHANNEL->stream->id);
        $stream->catchup = true;
        $stream->catchup_time = $this->CATCHUP_TIME;
        $stream->save();

        // create dir for stream
        $path = env('HOME_ENV_PATH').'/storage/app/public/store/streams';
        Storage::makeDirectory('/public/store/streams/' . $stream->id);
        
        $BASE_URL = env('APP_API_URL')."/api/stream/keys";
        exec("openssl rand 16 > ".storage_path('app/private/keys/')."$stream->id.key");
        exec("echo $BASE_URL/$stream->id > $path/$stream->id/$stream->id.keyinfo");
        exec("echo $stream->id.key >> $path/$stream->id/$stream->id.keyinfo");
        exec("echo $(openssl rand -hex 16) >> $path/$stream->id/$stream->id.keyinfo");
        
        // ffmpeg parameters for command
        if ($this->CATCHUP_TIME >= env('CATCHUP_TIME')) {
            $hls_time = 10;
            $hls_list_size = $this->CATCHUP_TIME/$hls_time;
            $playlist = "-hls_time $hls_time -hls_list_size $hls_list_size -hls_flags delete_segments";
        } else {
            $playlist = "-hls_flags delete_segments";
        }

        $header_cmd = '-re -hide_banner -y -hwaccel auto -stream_loop -1';
        $tail_cmd = "</dev/null >/dev/null 2>". env('HOME_ENV_PATH') ."/storage/logs/ffmpeg-$stream->id.log & echo $!";
        $map = " -ignore_unknown -codec copy -map 0:v -map 0:a ";
        $encrypt = "-hls_key_info_file $stream->id.keyinfo";
        $output = " -hls_segment_filename $path/$stream->id/$stream->id_%03d.ts $path/$stream->id/master.m3u8";

        // execute command as no hop and add echo $! to get pid of process
        exec("/home/".env('USER')."/bin/ffmpeg $header_cmd  -i \"$stream->vid_stream?overrun_nonfatal=1&fifo_size=200000\" $map $playlist $encrypt $output  $tail_cmd", $op);
        
        // save information of the process
        $process = new JobProcess();
        $process->pid = $op[0];
        $process->name = $this->CHANNEL->name;
        $process->stream = $stream->vid_stream;
        $process->log ='/var/log/ffmpeg-'. $stream->id .'.log';
        $process->command = 'catchup';        
        $process->save();
    }

}