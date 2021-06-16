<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\TypeIdentification;
use App\Traits\ClientTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

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
        Gate::authorize('haveaccess');

        return inertia('Client/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess');

        return inertia('Client/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientRequest $request)
    {

        $user = self::storeClient();

        return redirect()->route('client.edit',$user)
                ->with('success','El client se creó con éxito');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Gate::authorize('haveaccess');

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
        Gate::authorize('haveaccess');

        return inertia('Client/Edit', [
            'client' => self::getClient($id),
            'types_identification' => TypeIdentification::where('available',1)->get(),
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
    public function update(UpdateClientRequest $request, $id)
    {
        $this->validate($request,[
        
             'email' => 'required|string|max:255|email|unique:users,email,'.$id

        ]);

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
        Gate::authorize('haveaccess');
    }
}
