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
        $sectionItem->section = $request->input('section.id');
        $sectionItem->name = $request->input('item.name');
        $sectionItem->description = $request->input('item.description');
        if ($request->input('item.reservation') != NULL) {
            $sectionItem->reservation = $request->input('item.reservation');
        }
        if ($request->input('item.poster')) {
            $sectionItem->poster = $request->input('item.poster');
        }
        $sectionItem->longitude = $request->input('item.longitude');
        $sectionItem->latitude = $request->input('item.latitude');
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
        $sectionItem = SectionItem::find($request->input('item.id'));
        $sectionItem->name = $request->input('item.name');
        $sectionItem->description = $request->input('item.description');
        $sectionItem->reservation = $request->input('item.reservation');
        $sectionItem->latitude = $request->input('item.latitude');
        $sectionItem->longitude = $request->input('item.longitude');
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
