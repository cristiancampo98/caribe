<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users,email,' . $this->route('user')->id,
            'roles_id' => 'required|array|min:1'
        ];
    }

    public function messages()
    {
        return[
            'name.required'     =>  'El nombre es requerido',
            'email.required'    =>  'El correo es requerido',
            'email.unique'      =>  'El correo ya está en uso',
            'roles_id.required'     =>  'Seleccione un rol',
            'roles_id.array'        =>  'Seleccione uno o más roles'
        ];
    }
}
