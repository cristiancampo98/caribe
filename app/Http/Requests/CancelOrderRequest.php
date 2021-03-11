<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CancelOrderRequest extends FormRequest
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
            'note' => 'required|string|max:255'
        ];
    }

    public function messages()
    {
        return [
            'note.required' => 'La nota es obligatoria',
            'note.string' => 'La nota debe ser un texto',
            'note.max'  => 'La nota es demasiado larga'
        ];
    }
}
