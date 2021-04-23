<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VehicleUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class VehicleUserController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VehicleUser  $vehicleUser
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleUser $vehicleUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VehicleUser  $vehicleUser
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = VehicleUser::where('vehicle_id',$id)
        ->with('vehicle','client.details')
        ->orderBy('id','desc')
        ->get();

        $clients = User::whereHas('roles', function(Builder $query) {
            $query->where('roles.id',3);
        })->get();

        return inertia('Vehicle/Users/Edit', [
            'data' => $data,
            'clients' => $clients
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VehicleUser  $vehicleUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehicleUser $vehicleUser)
    {
        $vehicleUser->update($request->all());
        return response()->json([
            'item' => $vehicleUser,
            'type' => 'success',
            'text' => '¡El registro ha sido actualizado!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VehicleUser  $vehicleUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleUser $vehicleUser)
    {
        //
    }
}
