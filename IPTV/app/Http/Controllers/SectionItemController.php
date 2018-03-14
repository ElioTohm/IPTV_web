<?php

namespace App\Http\Controllers;

use App\SectionItem;
use Illuminate\Http\Request;

class SectionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 
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
        $sectionItem = new SectionItem();
        $sectionItem->section = $request->input('sectionid');
        $sectionItem->name = $request->input('name');
        $sectionItem->description = $request->input('description');
        $sectionItem->reservation = $request->input('reservation');
        $sectionItem->poster = $request->input('poster');
        $sectionItem->longitude = $request->input('longitude');
        $sectionItem->latitude = $request->input('latitude');
        $sectionItem->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SectionItem  $sectionItem
     * @return \Illuminate\Http\Response
     */
    public function show(SectionItem $sectionItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SectionItem  $sectionItem
     * @return \Illuminate\Http\Response
     */
    public function edit(SectionItem $sectionItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SectionItem  $sectionItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SectionItem $sectionItem)
    {
        $sectionItem = SectionItem::find($request->input('id'));
        $sectionItem->name = $request->input('name');
        $sectionItem->description = $request->input('description');
        $sectionItem->reservation = $request->input('reservation');
        $sectionItem->poster = $request->input('poster');
        $sectionItem->latitude = $request->input('latitude');
        $sectionItem->longitude = $request->input('longitude');
        $sectionItem->save();
        return $sectionItem;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SectionItem  $sectionItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SectionItem::destroy($id);

        return 200;
    }
}
