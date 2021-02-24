<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
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
            "name" => "required|unique:menus,name",
            "slug" => "required|string|max:50",
            "icon" => "required|string|max:50",
            "available" => "required|boolean",
            "isDirect" => "required|boolean",
        ];
    }

    public function messages()
    {
        return[
            'name.required'     =>  'El nombre es requerido',
            'name.unique'       =>  'El nombre ya está en uso',
            'slug.required'     =>  'El slug es requerido',
            'icon.required'     =>  'El icono es requerido',
            'available.required'    =>  'Seleccione un campo',
            'isDirect.required'     =>  'seleccione un campo'
        ];
    }
}
