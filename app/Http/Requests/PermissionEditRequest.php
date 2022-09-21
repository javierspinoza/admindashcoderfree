<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionEditRequest extends FormRequest
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
        $permission = $this->route('permission');
        return [
            'name' => 'required|unique:permissions,name,'.$this->permission.'|min:3|max:240',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Este campo no puede estar vacio',
            'name.min' => 'Este campo debe tener almenos 3 digitos',
            'name.max' => 'Este campo debe tener maximo 240 digitos',
            'name.unique' => 'Este permiso ya se encuentra registrado',
        ];
    }
}
