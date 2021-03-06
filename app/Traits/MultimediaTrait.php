<?php

namespace App\Traits;

use App\Models\Multimedia;
use Illuminate\Support\Facades\Storage;

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
	public static function storeMultimedia($files, $folder, $model, $reason, $foreign_key, $model_id)
	{
		foreach ($files as $key => $value) {
			Multimedia::create([
				'path' => $value->storePubliclyAs($folder, $value->getClientOriginalName(), 'public'),
				'filename' => $value->getClientOriginalName(),
				'model' => $model,
				'reason' => $reason,
				'foreign_key' => $foreign_key,
				'model_id' => $model_id
			]);
		}
	}

	/*
	 * Realiza la misma funcion de guardar archivos pero recibe un solo archivo
	 * @params: cumple con los mismos parametros de la funcion storeMultimedia
	 */
	public static function storeSingleFileMultimedia($file, $folder, $model, $reason, $foreign_key, $model_id)
	{
		return Multimedia::create([
			'path' => $file->storePubliclyAs($folder, $file->getClientOriginalName(), 'public'),
			'filename' => $file->getClientOriginalName(),
			'model' => $model,
			'reason' => $reason,
			'foreign_key' => $foreign_key,
			'model_id' => $model_id
		]);
	}

	public static function getMultimediaByParams($model, $foreign_key, $model_id, $reason)
	{
		return Multimedia::where('model', $model)
			->where('foreign_key', $foreign_key)
			->where('model_id', $model_id)
			->where('reason', $reason)
			->get();
	}

	public static function getMultimediaByWhereIn($data, $foreign_key)
	{
		return Multimedia::whereIn('model_id', $data)
			->where('foreign_key', $foreign_key)
			->get();
	}

	public static function downloadTrait($id)
	{
		$file = Multimedia::find($id);
		return Storage::disk('public')->download($file->path);
	}

	public static function destroyTrait($id)
	{
		$file = Multimedia::find($id);
		Storage::disk('public')->delete($file->path);
		return $file->delete();
	}

	public static function destroyMasiveMultimediaByParams($data, $foreign_key)
	{
		$multimedia = self::getMultimediaByWhereIn($data, $foreign_key);
		foreach ($multimedia as $key => $value) {
			Storage::disk('public')->delete($value->path);
			$value->delete();
		}
	}

	public static function destroyMultimediaByReason($reason, $foreign_key, $model_id)
	{
		$multimedia = Multimedia::where([
			'reason' => $reason,
			'foreign_key' => $foreign_key,
			'model_id' => $model_id,
		])->get();
		foreach ($multimedia as $key => $value) {
			Storage::disk('public')->delete($value->path);
			$value->delete();
		}
	}
}
