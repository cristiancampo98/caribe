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
        //if the form in coming from vehicle's module
        if ($this->get('index')) {
            return [
                'license_plate' => 'required|unique:vehicles,license_plate|string|max:10',
                'users_id'       =>  'required|array',
            ];    
        }

        return [
            'license_plate' => 'required|string|max:10',
            'user_id'       =>  'required_if:users_id,null|numeric',
        ];
    }

    public function messages()
    {
        return[
            'license_plate.required'     =>  'La placa del vehículo es requerida',
            'license_plate.unique'     =>  'La placa del vehículo ya ha sido registrada',
            'license_plate.max'     =>  'La placa del vehículo no puede exceder 10 carácteres',
            'user_id.required_if'           =>  'El cliente es requerido',
            'users_id.required'       =>  'Debes seleccionar al menos un cliente',
        ];
    }
}
