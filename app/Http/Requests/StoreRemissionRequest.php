<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRemissionRequest extends FormRequest
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
            'delivered' => 'required|numeric|min:1',
            'order_details_id' => 'required|numeric|min:1',
            'vehicle_users_id' => 'required|numeric|min:1',
            'consignment_id' => 'required|unique:remissions,consignment_id|numeric',
            'firm' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'plate' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'delivery' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }

    public function messages()
    {
        return[
            'delivered.required'        =>  'La cantidad entregada es requerida',
            'order_details_id.required'     =>  'El detalle de la orden es requerido',
            'vehicle_users_id.required'      =>  'El vehículo es obligatorio',
            'consignment_id.unique' => 'Este número de consignación ya fue usado',
            'consignment_id.required' => 'El número de consignación es requerido',
            'consignment_id.numeric' => 'El número de consignación es un campo númerico',
            'firm.required'     =>  'La firma es requerida',
            'firm.image'    =>  'El archivo debe ser imagen en algunos de estos formatos:jpeg,png,jpg,gif,svg',
            'plate.image'   =>  'El archivo debe ser imagen en algunos de estos formatos:jpeg,png,jpg,gif,svg',
            'delivery.image'    =>  'El archivo debe ser imagen en algunos de estos formatos:jpeg,png,jpg,gif,svg'
        ];
    }
}
