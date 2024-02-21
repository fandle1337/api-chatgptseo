<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestClientInstall extends RequestApiBase
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'license_key' => 'required|max:255',
            'module_code' => 'required|max:255',
            'domain'      => 'required|max:255',
        ];
    }
}
