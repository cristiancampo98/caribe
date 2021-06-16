<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'name_company' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users,email',
        ];
    }

    public function messages()
    {
        return [
            'name_company.required' => 'El nombre de la empresa es obligatorio',
            'name_company.string' => 'El nombre de la empresa debe ser una cadena de texto',
            'name_company.max' => 'El largo del nombre de la empresa son 255 carácteres',
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El correo es obligatorio',
            'email.unique'  => 'Este correo ya se encuentra en uso'
        ];
    }
}
