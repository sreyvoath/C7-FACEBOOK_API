<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPassword extends DefaultRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'passcode' => 'required|string|min:6', // Add validation for passcode
            'password' => 'required|string|min:8|confirmed', // new password
        ];
        return $rules;
    }
}
