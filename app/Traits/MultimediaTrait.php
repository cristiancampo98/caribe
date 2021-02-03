<?php

namespace App\Traits;

use App\Models\Multimedia;

/**
 * 
 */
trait MultimediaTrait
{
	/*
	* Upload files to project
	* @params: [
		files: archivos,
		folder: carpeta donde se guardaran ejemplo users
		model: modelo que carga los archivos ejemplo users
		foreign_key: convencion de llave foranea ejemplo user_id
		model_id: id del registro que cargo los archivos ejemplo 1
	]
	*/
	public function storeMultimedia($files, $folder, $model, $foreign_key, $model_id)
	{
		
		foreach ($files as $key => $value) {

			Multimedia::create([
				'path' => $value->storeAs('public/' .$folder , $value->getClientOriginalName()),
				'filename' => $value->getClientOriginalName(),
				'model' => $model,
				'foreign_key' => $foreign_key,
				'model_id' => $model_id
			]);	
		}
	}

    
}
