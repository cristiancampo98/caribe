<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Models\Vehicle;
use App\Traits\ClientTrait;
use App\Traits\VehicleTrait;
use App\Traits\Vehicle\Store\StoreVehicleTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VehicleController extends Controller
{
    use VehicleTrait;
    use StoreVehicleTrait;
    use ClientTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess');

        return inertia('Vehicle/Index', [
            'vehicles' => self::getAllVehicles(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess');

        $users = self::getAllUsersClient();

        return inertia('Vehicle/Create', [
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVehicleRequest $request)
    {
        if ($request->index) {
            $response = self::storeVehicle($request);
        }else {
            $response = self::storeVehicleFromRemission();    
        }
        

        if ($response) {
            if ($request->index) {
                return redirect()->route('vehicle.index')
                    ->with('success', 'El vehiculo se agrego con éxito');
            }
            return redirect()->back()
                    ->with('success', 'El vehiculo se agrego con éxito');
        }
        return redirect()->back()
                    ->with('error', 'Sucedió un error, no se pudo agregar el vehículo');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Gate::authorize('haveaccess');

        $vehicle = self::getVehicleWithRelationship($id);
        return inertia('Vehicle/Show', [
            'vehicle' => $vehicle
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        Gate::authorize('haveaccess');

        $users = self::getAllUsersClient();

        return inertia('Vehicle/Edit', [
            'vehicle' => $vehicle
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
    {
        try {
            $vehicle->users()->sync($request->users_id);
        } catch (Exception $e) {
            dd($e);
        }
        $vehicle = $vehicle->update($request->all());

        if ($vehicle) {

            return redirect()->route('vehicle.index')->with('success','El vehículo se actualizó con éxito');
        }

        return redirect()->back()->with('error','Sucedió un error,el vehículo no se actualizó con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        Gate::authorize('haveaccess');
    }

    public function editStatus($id)
    {
        return inertia('Vehicle/EditState', [
            'vehicle' => self::getVehicleById($id),
        ]);
    }

    /**
     * Update the state of specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function updateStatus($id)
    {
        $vehicle = self::updateStatusVehicle($id);

        if ($vehicle) {
            return redirect()->route('vehicle.index')->with('success','El vehículo se actualizó con éxito');
        }
        return redirect()->back()->with('error','Sucedió un error,el vehículo no se actualizó con éxito');

        
    }
}
