<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserStorageController extends Controller
{
    public function getPaginateAllUsers()
    {
    	return response()->json([
    		'users' => User::all(),
    	], 200);
    }
}
