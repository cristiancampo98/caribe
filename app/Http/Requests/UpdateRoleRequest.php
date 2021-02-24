<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
            'name' => 'required|string|max:50',
            'slug' => 'required|string|max:50|unique:roles,slug',
            'description' => 'required',
            'full_access' => 'required|',
            'public' => 'required|boolean'
        ];
    }

    public function messages()
    {
        return[
            'name.required'     =>  'El nombre es requerido',
            'slug.required'     =>  'El slug es requerido',
            'slug.unique'       =>  'El slug ya está en uso',
            'description.required'      =>  'La descripción es requerida',
            'full_access.required'      =>  'Seleccione una opción',
            'public.required'       =>  'Seleecione una opción'
        ];
    }
}
