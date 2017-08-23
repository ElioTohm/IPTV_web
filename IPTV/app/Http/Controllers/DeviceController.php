<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Device;

class DeviceController extends Controller
{
    public function getDevices () {
        // fetch all devices with id and room columns
        $devices = Device::get(['id', 'room']);
        return response()->json(['devices' => $devices]);
    }
}
