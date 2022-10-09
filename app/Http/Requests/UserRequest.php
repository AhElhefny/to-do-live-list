<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($this->method() == 'POST'){
            $password = 'required';
        }
        return [
            'name' => ['required',Rule::unique('users','name')->ignore($this->id)],
            'role_id' => 'required',
            'email' => 'email|required',
            'password' => $password ?? ''
        ];
    }
}
