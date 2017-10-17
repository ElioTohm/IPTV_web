<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppSettings;
use App\Http\Requests\AndroidAppRequest;

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

}
