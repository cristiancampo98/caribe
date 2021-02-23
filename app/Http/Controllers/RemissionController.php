<?php

namespace App\Http\Controllers;

use App\Traits\RemissionTrait;
use Illuminate\Http\Request;

class RemissionController extends Controller
{
    use RemissionTrait;
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
        $this->validate($request, [
            'delivered' => 'required|numeric|min:1',
            'order_details_id' => 'required|numeric|min:1',
            'vehicle_users_id' => 'required|numeric|min:1',
            'firm' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'plate' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'delivery' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $response = self::storeRemission($request);

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Remission  $remission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Remission  $remission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
