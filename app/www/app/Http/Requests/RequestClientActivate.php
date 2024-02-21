<?php

namespace App\Http\Requests;


class RequestClientActivate extends RequestApiBase
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
/*            "coupon" => "required",
            "code" => "required",
            "name" => "required",
            "email" => "required",*/
            "clientKeyHash" => "required"
        ];
    }
}
