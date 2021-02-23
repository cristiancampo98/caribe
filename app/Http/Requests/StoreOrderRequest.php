<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'user_id' => 'required|numeric|min:1' ,
            'shipping_address' => 'required|string|max:100' ,
            'city' => 'required|string|max:100' ,
            'order_details' => 'required|array|min:1',
            'order_id' => 'nullable|numeric',
            'consignment.consignment_number' => 'nullable|unique:consignments,consignment_number'
        ];
    }

    public function messages()
    {
        return[
            'user_id.required'   =>  'Seleccione un cliente',
            'shipping_address.required'      =>  'La dirección de envío es obligatoria',
            'city.required'     =>  'La ciudad es obligatoria',
            'order_details.required'     =>  'Seleccione un producto'
        ];
    }
}
