<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return [
            'name'           => ['required', 'regex:/^[\pL\s\-]+$/u'],
            'email'          => ['required', 'email'],
            'password'       => ['required', 'min:6'],
            'supervisor_npp' => ['exists:users,npp'],

        ];
    }
}