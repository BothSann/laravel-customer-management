<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
{



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [    
            "image" =>[ "nullable", "image"],
            "first_name" => ["required", "string",  "min:2", "max:255"],
            "last_name" => ["required", "string",  "min:2", "max:255"],
            "email"=> ["required","email", "max:255"],
            "phone" => ["required", "string", "min:10", "max:15"],
            "bank_account_number" => ["required", "string", "min:11", "max:11"],
            "about" => ["nullable", "string", "max:500"]
        ];
    }
}
