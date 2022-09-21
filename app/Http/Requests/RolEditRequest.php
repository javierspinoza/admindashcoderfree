<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolEditRequest extends FormRequest
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
        // $role = $this->route('role');
        return [
            'name' => ['min:3', 'max:240', 'unique:roles,name,' . request()->route('role')->id],
        ];
    }

    public function messages(){
        return [
            'name.min' => 'Este campo debe tener almenos 3 digitos',
            'name.max' => 'Este campo debe tener maximo 240 digitos',
            'name.unique' => 'Este rol ya se encuentra registrado',
        ];
    }
}
