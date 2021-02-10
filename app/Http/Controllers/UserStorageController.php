<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserStorageController extends Controller
{
    public function getPaginateAllUsers(Request $request)
    {
    	return response()->json([
    		'users' => User::paginate(3),
    	], 200);
    	
    }
}
