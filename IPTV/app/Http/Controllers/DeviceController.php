<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Device;
use App\oAuthClient;
use App\Http\Requests\DeviceRequest;

class DeviceController extends Controller
{
    public function getDevices () 
    {
        // fetch all devices with id and room columns
        $devices = Device::with('oAuthclient')->orderBy('room')->get(['id', 'room']);

        return response()->json([
                'devices' => $devices,
            ]);
    }

    
    public function addDevice (DeviceRequest $request) 
    {
        $lastdevice = Device::all(['id'])->last();
        $lasttoken = oAuthClient::all(['id'])->last();

        if ($lastdevice['id'] < $lasttoken['id']){
            $device = new Device();
            $device->room = $request->input('room');
            $device->save();
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
        $device->delete();

    }
}
