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
        $path = $request->file('apk')->storeAs('public', 'xmslauncher.apk');
        
        return response()->json([
            'response'=> $request->get('version')
        ]);
    }

}
