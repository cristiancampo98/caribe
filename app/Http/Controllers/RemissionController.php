<?php

namespace App\Http\Controllers;

use App\Models\Remission;
use Illuminate\Http\Request;

class RemissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia('Remission/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Remission/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Remission  $remission
     * @return \Illuminate\Http\Response
     */
    public function show(Remission $remission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Remission  $remission
     * @return \Illuminate\Http\Response
     */
    public function edit(Remission $remission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Remission  $remission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Remission $remission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Remission  $remission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Remission $remission)
    {
        //
    }
}
