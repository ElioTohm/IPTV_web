<?php

namespace App\Http\Controllers;

use App\IpCam;
use Illuminate\Http\Request;

class IpCamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return all cams 
        return IpCam::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ipcam = new IpCam();
        $ipcam->ip = $request->input('ip');
        $ipcam->username = $request->input('username');
        $ipcam->password = $request->input('password');
        $ipcam->channel = $request->input('channel');
        $ipcam->save();
        
        return 200;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IpCam  $ipCam
     * @return \Illuminate\Http\Response
     */
    public function show(IpCam $ipCam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IpCam  $ipCam
     * @return \Illuminate\Http\Response
     */
    public function edit(IpCam $ipCam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IpCam  $ipCam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IpCam $ipcam)
    {
        $ipcam->ip = $request->input('ip');
        $ipcam->username = $request->input('username');
        $ipcam->password = $request->input('password');
        $ipcam->channel = $request->input('channel');
        $ipcam->save();

        return 200;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IpCam  $ipCam
     * @return \Illuminate\Http\Response
     */
    public function destroy(IpCam $ipcam)
    {
        $ipcam->delete();
    }
}
