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
            'login' => ['required', 'string', 'lowercase', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'name' => ['required', 'string', 'max:255'],
            'password' => ['string', 'max:255', Password::defaults()],
            'role' => ['required', 'string', 'max:50'],
            'partner_id' => ['integer'],
            'is_disabled' => ['required', 'boolean']
        ];
    }
}
