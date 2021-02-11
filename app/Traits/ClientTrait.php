<?php

namespace App\Traits;

use App\Models\RoleUser;
use App\Models\User;
use App\Traits\MultimediaTrait;
use App\Traits\VehicleTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Iluminate\Http\Request;

/**
 * 
 */
trait ClientTrait
{
	use MultimediaTrait;
	use VehicleTrait;

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

			if (request()->filled('vehicles')) {
				self::storeVehicleFromClient(request()->get('vehicles'),$id);
			}

			if (request()->file('photo_document')) {
				self::storeSingleFileMultimedia(
					request()->file('photo_document'), 
					'documents', 
					'users', 
					'photo_document', 
					'user_id', 
					$id
				);
			}

			if (request()->file('rut_document')) {

				self::storeSingleFileMultimedia(
					request()->file('rut_document'), 
					'documents', 
					'users', 
					'rut_document', 
					'user_id', 
					$id
				);
			}

			if (request()->file('logo')) {

				self::storeSingleFileMultimedia(
					request()->file('logo'), 
					'documents', 
					'users', 
					'logo', 
					'user_id', 
					$id
				);
			}

			if ($detail) {
				return $user;
			}
		}
		return false;
	}

	public static function getAllClients(){
        
        return RoleUser::where('role_id',3)->get();
    }

	public static function getAllClientsPaginate(){
        
        return RoleUser::where('role_id',3)->paginate(request()->get('lenght'));
    }

    public static function getClientsToOrder(){
    	return DB::table('users')
    	->join('user_details', 'users.id','user_details.user_id')
    	->join('role_users', 'users.id','role_users.user_id')
    	->where('role_id',3)
    	->where('users.name', 'like', '%'.request()->get('q').'%')
    	->orWhere('user_details.name_company', 'like', '%'.request()->get('q').'%')
    	->where('role_id',3)
    	->select(
    		'users.id as id',
    		'users.name as name',
    		'user_details.name_company as name_company'
    	)->get();
    }
}
