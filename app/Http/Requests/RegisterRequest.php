<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:150',
            'email'    => 'required|email|max:100',
            'password' => 'required|string|min:8',
        ];
    }
}
