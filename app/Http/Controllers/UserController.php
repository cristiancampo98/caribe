<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\TypeBlood;
use App\Models\TypeIdentification;
use App\Models\User;
use App\Traits\MultimediaTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use MultimediaTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia('User/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('User/Create', [
            'roles' => Role::where('public',1)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::storeUser();

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return inertia('User/Show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return inertia('User/Edit', [
            'user' => $user,
            'types_identification' => TypeIdentification::where('available',1)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $detail = User::storeUserDetail($request->all(), $user->id);
        if ($request->has('photo_document')) {

            self::storeSingleFileMultimedia(
                request()->file('photo_document'), 
                'documents', 
                'users', 
                'photo_document', 
                'user_id', 
                $user->id
            );
        }
        return redirect()->route('user.index')->with('info','El proceso se realizó con éxito');
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

    public function updateStatus($id)
    {

        $user = User::find($id);

        if ($user->status) {

            $user->status = 0;
            $text = 'El cliente se inactivo con éxito';
        }else{

            $user->status = 1;
            $text = 'El cliente se activo con éxito';
        }

        if ($user->save()) {
            $type = 'success';
        }else {

            $type = 'error';
            $text = 'Sucedió un error, el cliente no se actualizó';
        }

        if (request()->wantsJson()) {

            return  response()->json([
                'user' => $user,
                'type' => $type,
                'text' => $text
            ],200);
        }else {

            return redirect()->back()->with($type, $text);
        }
    }
}
