<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserStorageController extends Controller
{
    public function getPaginateAllUsers(Request $request)
    {
    	return User::paginate(request()->get('lenght'));
    	
    }
}
