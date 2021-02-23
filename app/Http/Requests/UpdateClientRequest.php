<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            'type_pay' => 'required|in:contado,crédito',
            'name' => 'required|string|max:255',
            'name_company' => 'required|string|max:50'
        ];
    }

    public function messages()
    {
        return [
            'type_pay.required' => 'El tipo de pago es obligatorio',
            'name.required'              => 'El nombre es obligatorio',
            'name_company.required' => 'La empresa es obligatorio'
        ];
    }
}
