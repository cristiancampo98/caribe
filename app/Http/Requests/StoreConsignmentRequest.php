<?php

namespace App\Http\Requests;

use App\Rules\isActiveOrder;
use Illuminate\Foundation\Http\FormRequest;

class StoreConsignmentRequest extends FormRequest
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
            'order_id' => ['required','numeric', 'exists:orders,id' ,new isActiveOrder],
            'consignment_number' => 'required|unique:consignments,consignment_number|numeric',
        ];
    }

    public function messages()
    {
        return [
            'order_id.required' => 'El consecutivo de la orden es requerido',
            'order_id.numeric' => 'El consecutivo de la orden es númerico',
            'order_id.exists' => 'El consecutivo de la orden es debe de existir',
            'consignment_number.required' => 'El número de consignación es requerido',
            'consignment_number.unique' => 'El número de consignación ya se encuentra registrado',
            'consignment_number.numeric' => 'La consignación debe ser númerica',
        ];
    }
}
