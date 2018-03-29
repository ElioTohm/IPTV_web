<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Device;
use App\User;
use App\oAuthClient;
use App\Http\Requests\DeviceRequest;

class DeviceController extends Controller
{
    public function getDevices () 
    {
        // fetch all devices with id and room columns
        $devices = Device::with('Authclient')->orderBy('room')->select(['id', 'room'])->paginate(env('ITEM_PER_PAGE'));
        foreach ($devices as $device) {
            $device->authclient->secret = substr($device->authclient->secret,0, 4);
        }
        return $devices;
    }

    
    public function addDevice (DeviceRequest $request) 
    {
        $lastdevice = Device::all(['id'])->last();
        $unsigned_oAtuh = oAuthClient::where('assigned_to', 0)->first();
        
        if ($unsigned_oAtuh != null) {
            $device = new Device();
            $device->id = $unsigned_oAtuh->id;
            $device->room = $request->input('room');
            $device->save();

            $unsigned_oAtuh->assigned_to = 1;
            $unsigned_oAtuh->save();

            return $device;
        } else {
            return response()->json([
                'error' => 'Cannot add more devices',
            ]);
        }

    }

    public function updateDevice ($id, DeviceRequest $request) 
    {
        $device = Device::find($id);
        
        $device->room = $request->input('room');

        $device->save();

    }

    public function deleteDevice ($id) 
    {
        $device = Device::find($id);
        $roomid = $device->room;
        $device->delete();
        
        $oauthclient = oAuthClient::find($id);
        $oauthclient->assigned_to = 0;
        $oauthclient->registered = 0;
        $oauthclient->save();

        $user = User::where('email', $roomid . '@dvb.com')
                ->first();   
        if ($user != NULL) {
            $user->delete();
        }
    }
}
