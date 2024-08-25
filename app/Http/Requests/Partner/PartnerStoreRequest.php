<?php

namespace App\Http\Requests\Partner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class PartnerStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $unique = Rule::unique('partners');

        return [
            'inn'                => ['nullable', 'string', 'max:12'],
            'organization'       => ['nullable', 'string', 'max:255'],
            'name'               => ['required', 'string', 'max:255', $unique],
            'contract_number'    => ['required', 'string', 'max:50', $unique],
            'email'              => ['nullable', 'email'],
            'telnums.*.number'   => ['nullable', 'string', 'min:11', 'max:12'],
            'telnums.*.name'     => ['nullable', 'string', 'max:50'],
            'yclients_id'        => ['nullable', 'string', 'max:255'],
            'address'            => ['nullable', 'string', 'max:255'],
            'start_at'           => ['nullable', 'date_format:Y-m-d'],
            'disabled'           => ['boolean']
        ];
    }
}
