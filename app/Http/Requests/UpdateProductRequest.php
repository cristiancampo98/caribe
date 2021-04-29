<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|string|max:100|unique:products,name,' . $this->route('product'),
            'reference' => 'nullable|string|max:50',
            'cubic_meters' => 'required|numeric|min:0.1|max:99.9',
            'ton' => 'required|numeric|min:0.1|max:99.9',
            'limit_day' => 'required|numeric|min:1|max:999.9'
        ];
    }

    public function messages()
    {
        return [
            'name.required'     =>  'El nombre es requerido',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'name.max' => 'El nombre no puede tener mas de 100 caracteres',
            'name.unique' => 'El nombre ya se encuentra registrado',
            'reference.string' => 'La referencia debe ser una cadena de texto',
            'reference.max' => 'La referencia no puede tener mas de 100 caracteres',
            'cubic_meters.required' => 'Los metros cúbicos son requeridos',
            'cubic_meters.numeric' => 'Los metros cúbicos son númericos',
            'cubic_meters.min' => 'La cantidad mínima de metros cúbicos es 0.1',
            'cubic_meters.max' => 'La cantidad máxima de metros cúbicos es 99.9',
            'ton.required' => 'La tonelada es requerida',
            'ton.numeric' => 'La tonelada debe ser númerica',
            'ton.min' => 'La cantidad mínima de la tonelada es 0.1',
            'ton.max' => 'La cantidad máxima de la tonelada es 99.9',
            'limit_day.required' => 'El límite díario es requerido',
            'limit_day.numeric' => 'El límite díario es requerido',
            'limit_day.min' => 'La cantidad mínima del límite díario es 1',
            'limit_day.max' => 'La cantidad máxima del límite díario es 999.9',
        ];
    }
}
