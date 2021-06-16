<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:100|unique:products',
            'reference' => 'nullable|string|max:50',
            'cubic_meters' => 'required|numeric|min:0.1',
            'ton' => 'required|numeric|min:0.1',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     =>  'El nombre es requerido',
            'name.unique'       =>  'El nombre ya existe',
            'cubic_meters.required' => 'La equivalencia en metros cúbicos es requerida',
            'cubic_meters.numeric' => 'La equivalencia en metros cúbicos debe ser númerica',
            'cubic_meters.min' => 'La equivalencia miníma en metros cúbicos es 0.1',
            'ton.required' => 'La equivalencia en toneladas es requerida',
            'ton.numeric' => 'La equivalencia en toneladas debe ser númerica',
            'ton.min' => 'La equivalencia miníma en toneladas es 0.1',
        ];
    }
}
