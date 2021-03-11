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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        Gate::authorize('haveaccess');

        return inertia('User/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess');

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
        Gate::authorize('haveaccess');

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
        Gate::authorize('haveaccess');

        if (Auth::user()->isAdmin()) {
            $roles = Role::all();
        }else {
            $roles = Role::where('public', 1)->get();
        }

        return inertia('User/Edit', [
            'user' => $user,
            'roles' => $roles,
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
        $user->details->update($request->all());
        $user->roles()->sync($request->roles_id);
        
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
        return redirect()->route('user.index')->with('success','El proceso se realizó con éxito');
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
