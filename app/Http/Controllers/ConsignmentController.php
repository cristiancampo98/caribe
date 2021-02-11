<?php

namespace App\Http\Controllers;

use App\Traits\ConsignmentTrait;
use Illuminate\Http\Request;


class ConsignmentController extends Controller
{
    use ConsignmentTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia('Consignment/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Consignment/Create');
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
            'order_id' => 'required|numeric'
        ]);

        self::storeConsignment();
        return redirect()->route('consignment.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consignment  $consignment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return inertia('Consignment/Show', [
            'consignment' => self::findConsignment($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consignment  $consignment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return inertia('Consignment/Edit', [
            'consignment' => self::findConsignment($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consignment  $consignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        self::updateConsignment($id);

        return redirect()->route('consignment.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consignment  $consignment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
