<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'user_id' => 'required|numeric|min:1',
            'shipping_address' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'order_details' => 'required|array|min:1',
            'order_details.*.quantity' => 'numeric|max:9999.999|min:1',
            'pse_url' => 'nullable|url',
            'pse_number' => 'nullable|numeric',
            'contract' => 'required_if:credit_documents,false',
            'purchaseOrder' => 'required_if:credit_documents,false',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Seleccione un cliente',
            'shipping_address.required' => 'La dirección de envío es obligatoria',
            'city.required' => 'La ciudad es obligatoria',
            'order_details.required' => 'Seleccione un producto',
            'order_details.array' => 'Debes seleccionar uno o más productos',
            'order_details.*.quantity.max' => 'La cantidad del pedido no puede ser mayor a 9999.999',
            'order_details.*.quantity.min' => 'La cantidad del pedido no puede ser menor a  1',
            'order_details.*.quantity.numeric' => 'La cantidad del pedido debe ser númerica',
            'contract.required_if' => 'El contrato es requerido porque el  tipo de pago es crédito',
            'purchaseOrder.required_if' => 'La orden de compra es  requerida porque el tipo de pago es crédito'
        ];
    }
}
