<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UserStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $unique = Rule::unique('users');

        return [
            'login' => ['required', 'string', 'lowercase', 'min:2', 'max:255', $unique],
            'name' => ['nullable', 'string', 'min:2', 'max:255'],
            'password' => ['required', 'min:8', 'max:50'],
            'role' => ['required', 'string', 'max:50'],
            'partner_id' => ['required', 'integer'],
            'is_disabled' => ['required', 'boolean']
        ];
    }
}
