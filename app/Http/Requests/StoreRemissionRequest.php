<?php

namespace App\Http\Requests;

use App\Rules\LimitDeliveryStore;
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
            'delivered' => ['required','numeric','min:0', new LimitDeliveryStore($this->order_details_id)],
            'order_details_id' => 'required|numeric|min:1',
            'vehicle_users_id' => 'required|numeric|min:1'
        ];
    }

    public function messages()
    {
        return[
            'delivered.required'        =>  'La cantidad entregada es requerida',
            'order_details_id.required'     =>  'El detalle de la orden es requerido',
            'vehicle_users_id.required'      =>  'El vehículo es obligatorio'
        ];
    }
}
