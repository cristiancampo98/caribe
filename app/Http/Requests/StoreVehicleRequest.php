<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'license_plate' => 'required|string|max:10',
            'user_id'       =>  'required|numeric'
        ];
    }

    public function messages()
    {
        return[
            'license_plate.required'     =>  'La placa es requerida',
            'user_id.required'           =>  'El cliente es requerido'
        ];
    }
}
