<?php

namespace App\Http\Requests;

class RequestClientTokenAdd extends RequestApiBase
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'value' => 'required|max:255|integer',
            "client_license_hash" => 'required|max:255|string',
        ];
    }
}
