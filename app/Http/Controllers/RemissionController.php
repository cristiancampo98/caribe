<?php

namespace App\Http\Controllers;

use App\Events\StoredRemission;
use App\Http\Requests\StoreRemissionRequest;
use App\Http\Requests\UpdateRemissionRequest;
use App\Traits\RemissionTrait;
use App\Traits\Remission\Update\UpdateRemissionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RemissionController extends Controller
{
    use RemissionTrait;
    use UpdateRemissionTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess');

        return inertia('Remission/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess');

        return inertia('Remission/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRemissionRequest $request)
    {
        $response = self::storeRemission($request);

        if ($response) {
            StoredRemission::dispatch($response);
        }

        return $response ? redirect()->route('remission.index')->with('success','La remisión se creo con éxito')
                        : redirect()->back()->with('error','Sucedió un error, no se pudo crear la remisión');

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Remission  $remission
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Gate::authorize('haveaccess');

        return inertia('Remission/Show',[
            'remission' => self::getRemissionByIdWithRelationships($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Remission  $remission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('haveaccess');

        return inertia('Remission/Edit',[
            'remission' => self::getRemissionByIdWithRelationships($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Remission  $remission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRemissionRequest $request, $id)
    {
        Gate::authorize('haveaccess');   

        $response = self::updateRemission($id, $request);

        if ($response) {
            StoredRemission::dispatch($response);
        }

        return $response ? redirect()->route('remission.index')->with('success','La remisión se editó con éxito')
                        : redirect()->back()->with('error','Sucedió un error, no se pudo editar la remisión');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Remission  $remission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('haveaccess');
    }
}
