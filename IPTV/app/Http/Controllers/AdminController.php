<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppSettings;
use App\WebStorage;
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
        $path = explode('/', $path);
        $enduserapp = AppSettings::where('app', 'launcher')->first();
        $enduserapp->version = $request->get('version') ;
        $enduserapp->apk_path = $path[sizeof($path) - 1];
        $enduserapp->save();
        
        return response()->json([
            'response'=> 200
        ]);
    }

    public function getStorages () 
    {
        return WebStorage::all();
    }

    public function addStorage (Request $request) 
    {
        $storage = new WebStorage ();
        $storage->server_url = $request->input('server_url');
        $storage->server_dir = $request->input('server_dir');
        $storage->local_dir = $request->input('local_dir');
        // $this->mountNFSStorage($storage);
        $storage->save();
        return 200;
    }

    public function updateStorage (Request $request) 
    {
        $storage = WebStorage::find($request->input('id'));
        $storage->server_url = $request->input('server_url');
        $storage->server_dir = $request->input('server_dir');
        $storage->local_dir = $request->input('local_dir');
        // $this->mountNFSStorage($storage);
        $storage->save();
    }

    public function removeStorage ($id)
    {
        $storage = WebStorage::find($id);
        $storage->delete();
        return 200;
    }

    // mount storage
    private function mountNFSStorage (Storage $storage) 
    {
        $exec = sprintf("mount -F nfs %s:/%s /%s", 
                        $storage->server_name,
                        $storage->server_dir,
                        $storage->local_dir);

        $process = new Process($exec);
        $process->run();

        // executes after the command finishes
        while ($process->isRunning()) {
            // waiting for process to finish
        }

        return $process->getErrorOutput();
    }
    
}
