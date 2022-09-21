<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'name' => 'required|min:3|max:200',
            'email' => 'required|email|min:5|max:255|unique:users',
            'password' => 'required|min:6|max:255'
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Este campo es obligatorio',
            'name.min' => 'Este campo debe tener almenos 3 caracteres',
            'name.max' => 'Este campo debe tener máximo 200 caracteres',
            'email.required' => 'Este campo es obligatorio',
            'email.email' => 'Este campo debe ser de tipo Email',
            'email.min' => 'Este campo debe tener almenos 5 caracteres',
            'email.max' => 'Este campo debe tener máximo 255 caracteres',
            'email.unique' => 'Este Email ya se encuentra registrado',
            'password.required' => 'Este campo es obligatorio',
            'password.min' => 'Este campo debe tener almenos 6 caracteres',
            'password.max' => 'Este campo debe tener máximo 255 caracteres',
        ];
    }
}
