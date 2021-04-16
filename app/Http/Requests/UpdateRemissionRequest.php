<?php

namespace App\Http\Requests;

use App\Rules\LimitDeliveryUpdate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRemissionRequest extends FormRequest
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
            'delivered' => ['required','numeric','min:0', new LimitDeliveryUpdate($this->route('remission'))],
            'vehicle_users_id' => 'required|exists:vehicles,id',
            'firm' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'plate' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'delivery' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }

    public function messages()
    {
        return [
            'delivered.required' => 'La cantidad a entregar es requerida',
            'delivered.numeric' => 'La cantidad a entregar es númerica',
            'vehicle_users_id.required' => 'El vehículo es obligatorio',
            'vehicle_users_id.exists' => 'El identificativo del vehículo debe de existir en vehículos',
            'firm.required'     =>  'La firma es requerida',
            'firm.image'    =>  'El archivo debe ser imagen en algunos de estos formatos:jpeg,png,jpg,gif,svg',
            'plate.image'   =>  'El archivo debe ser imagen en algunos de estos formatos:jpeg,png,jpg,gif,svg',
            'delivery.image'    =>  'El archivo debe ser imagen en algunos de estos formatos:jpeg,png,jpg,gif,svg'
        ];
    }
}
