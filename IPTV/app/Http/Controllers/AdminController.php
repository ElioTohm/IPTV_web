<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use App\AppSettings;
use App\Http\Requests\AndroidAppRequest;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


class AdminController extends Controller
{
    // return admin view
    public function index () 
    {
        return view('admin.admin');
    }

    // return Enduserapp info
    public function getLauncherApp (Request $request) 
    {
        $enduserapp = AppSettings::where('app', 'launcher')->first();

        return $enduserapp;
    }

    // update enduserapp info
    public function updateLauncherApp (Request $request) 
    {
        $path = $request->file('apk')->storeAs('apk', 'xmslauncher.apk', 'private');
        
        $enduserapp = AppSettings::where('app', 'launcher')->first();
        $enduserapp->version = $request->get('version') ;
        $enduserapp->apk_path = $path;
        $enduserapp->save();
        
        return response()->json([
            'response'=> 200
        ]);
    }

    public function runTimeShift (Request $request) 
    {
        $channel = Channel::with('stream')->find($request->input('channel_id'));
        
        $exec = sprintf("ffmpeg -re -hide_banner 
                        -i \"%s?fifo_size=50000\" 
                        -codec copy 
                        -map 0 
                        -hls_time 10 
                        -hls_list_size 3 
                        -hls_flags delete_segments 
                        -hls_segment_filename /var/www/storage/app/public/streams/%s/%s_%%03d.ts 
                        /var/www/storage/app/public/streams/%s/master.m3u8", 
                        $channel->stream->vid_stream,
                        $channel->name,
                        $channel->name,
                        $channel->name);

        $process = new Process($exec);
        $process->run();

        // executes after the command finishes
        while ($process->isRunning()) {
            // waiting for process to finish
        }

        return $process->getErrorOutput();
    }

}
