<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;


class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'max:50', 'confirmed'],
            'password_confirmation' => ['required', 'min:8', 'max:50'],
        ];
    }
}
