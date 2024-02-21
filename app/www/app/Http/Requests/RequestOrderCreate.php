<?php

namespace App\Http\Requests;


class RequestOrderCreate extends RequestApiBase
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "product_id" => "required|int|max:255",
            'license_key' => 'required|max:255',
        ];
    }
}
