<?php

namespace App\Http\Requests\Call;

use Illuminate\Foundation\Http\FormRequest;


class CallUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'mango_telnum'       => ['nullable', 'string', 'min:11', 'max:12'],
            'tg_disabled'        => ['boolean'],
            'tg_chat_id'         => ['nullable', 'string', 'max:255'],
            'pay_end'            => ['nullable', 'date_format:Y-m-d'],
            'new_client_days'    => ['required', 'integer'],
            'repeat_client_days' => ['required', 'integer'],
            'lost_client_days'   => ['required', 'integer']
        ];
    }
}
