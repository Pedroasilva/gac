<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;

class PasswordUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed'],
        ];
    }
}
