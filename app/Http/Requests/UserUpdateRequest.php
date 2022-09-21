<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'email' => ['required', 'email', 'min:6', 'max:200', 'unique:users,email,' . request()->route('user')->id],
            'password' => 'sometimes|max:200',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Este campo es obligatorio',
            'name.min' => 'Este campo debe tener almenos 3 caracteres',
            'name.max' => 'Este campo debe tener máximo 200 caracteres',
            'email.required' => 'Este campo es obligatorio',
            'email.email' => 'Este campo es de tipo Email',
            'email.min' => 'Este campo debe tener almenos 6 caracteres',
            'email.max' => 'Este campo debe tener máximo 200 caracteres',
            'email.unique' => 'Este Email ya se encuentra registrado',
            'password.sometimes' => 'Su contraseña debe ser cambiada a menudo',
            'password.max' => 'Este campo debe tener máximo 200 caracteres',
        ];
    }
}
