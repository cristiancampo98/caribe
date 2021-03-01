<?php

namespace App\Http\Controllers;

use App\Models\TypeBlood;
use App\Models\TypeIdentification;
use App\Traits\ClientTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PDF;

class ClientController extends Controller
{
    use ClientTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia('Client/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imprimir(){
        $clients = \DB::table('user_details')
        ->select('user_details.*', 'users.name')
        ->join('users', 'user_details.user_id', '=',  'users.id')
        ->orderBy('id', 'ASC')
        ->take(10)
        ->get();
        $fecha = date('y-m-d');
        $data = compact('clients', 'fecha');
        $pdf = PDF::loadView('pdf.reportclient', $data);
    }

    public function create()
    {
        return inertia('Client/Create');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users'
        ]);

        $user = self::storeClient();

        return redirect()->route('client.edit',$user);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return inertia('Client/Show', [
            'client' => self::getClientWithRelationships($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return inertia('Client/Edit', [
            'client' => self::getClient($id),
            'types_identification' => TypeIdentification::where('available',1)->get(),
            'types_blood' => TypeBlood::where('available',1)->get(),
            'photo_document' => self::getMultimediaByParams('users', 'user_id', $id, 'photo_document'),
            'rut_document' => self::getMultimediaByParams('users', 'user_id', $id, 'rut_document'),
            'logo' => self::getMultimediaByParams('users', 'user_id', $id, 'logo')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = self::updateClient($id);

        return $client ? redirect()->route('client.index')->with('success','El cliente se actualizó con éxito')
                : redirect()->back()->with('error','Sucedió un error,el cliente no se actualizó');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
