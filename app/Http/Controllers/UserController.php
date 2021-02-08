<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users',
            'roles_id' => 'required|array|min:1'
        ]);

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
            'types_identification' => TypeIdentification::where('available',1)->get(),
            'types_blood' => TypeBlood::where('available',1)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
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
        return redirect()->back();
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
        }else{
            $user->status = 1;
        }
        $user->save();

        return response()->json([
            'user' => $user,
        ], 200);
    }
}
