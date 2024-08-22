<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;


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
            'login' => ['required', 'string', 'lowercase', 'max:255', Rule::unique('users')->ignore($this->user->id, 'id')],
            'name' => ['nullable', 'string', 'min:2', 'max:255'],
            'password' => ['nullable', 'string', 'max:255', Password::defaults()],
            'role' => ['required', 'string', 'max:50'],
            'partner_id' => ['required', 'integer'],
            'is_disabled' => ['required', 'boolean']
        ];
    }
}
