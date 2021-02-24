<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
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
            'name' => 'required|unique:permissions,name',
            'slug' => 'required|unique:permissions,slug',
            'controller' => 'required'
        ];
    }

    public function messages()
    {
        return[
            'name.required'     =>  'El nombre es requerido',
            'name.unique'       =>  'Este nombre ya está en uso',
            'slug.required'     =>  'El slug es requerido',
            'slug.unique'       =>  'Este nombre ya está en uso',
            'controller.required'   =>  'El controlador es requerido'
        ];
    }
}
