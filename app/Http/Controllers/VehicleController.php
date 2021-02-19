<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Traits\VehicleTrait;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    use VehicleTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        return inertia('Vehicle/Create');
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
            'license_plate' => 'required|string|max:10'
        ]);
        
        $response = self::storeVehicleFromRemission();

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
    public function update(Request $request, Vehicle $vehicle)
    {
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
        //
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
