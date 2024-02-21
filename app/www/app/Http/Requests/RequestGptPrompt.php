<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestGptPrompt extends RequestApiBase
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "prompt"      => "required",
            'gpt_code'    => "required",
            'license_key' => 'required|max:255',
            'module_code' => 'required|max:255',
            'task_id'     => 'int',
            'element_id'  => 'int',
        ];
    }
}
