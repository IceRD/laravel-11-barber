<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string', 'lowercase', 'min:2', 'max:255', Rule::unique('users')->ignore($this->user->id, 'id')],
            'name' => ['nullable', 'string', 'min:2', 'max:255'],
            'password' => ['nullable', 'min:8', 'max:50'],
            'role' => ['required', 'string', 'max:50'],
            'partner_id' => ['required', 'integer'],
            'is_disabled' => ['required', 'boolean']
        ];
    }
}
