<?php

namespace App\Traits;

use App\Models\RoleUser;
use App\Models\User;
use App\Traits\MultimediaTrait;
use Illuminate\Support\Facades\Hash;
use Iluminate\Http\Request;

/**
 * 
 */
trait ClientTrait
{
	use MultimediaTrait;

	public static function getClient($id)
	{
		return User::find($id);
	}

	public static function storeClient()
	{
		$user = (new User)->fill(request()->all());
		$user->password = Hash::make('12345678');
		$user->save();
		$user->roles()->sync(3);
		return $user;
	}

	public static function updateClient($id)
	{
		$user = User::where('id',$id)->update([
			'name' => request()->name,
			'email' => request()->email
		]);

		if ($user) {
			$detail = User::storeUserDetail(request()->all(),$id);

			if (request()->has('photo_document')) {

				self::storeSingleFileMultimedia(request()->file('photo_document'), 'documents', 'users', 'user_id', $id);
			}

			if (request()->has('rut_document')) {

				self::storeSingleFileMultimedia(request()->file('rut_document'), 'documents', 'users', 'user_id', $id);
			}

			if ($detail) {
				return $user;
			}
		}
		return false;
	}

	public static function getClients(){
        
        return RoleUser::where('role_id',3)->get();
    }
}
