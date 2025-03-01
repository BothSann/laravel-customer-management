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
            "image" =>[ "nullable"],
            "first_name" => ["required", "string",  "min:4", "max:255"],
            "last_name" => ["required", "string",  "min:4", "max:255"],
            "email"=> ["required","email"],
            "phone" => ["required", "string", "min:10", "max:15"],
            "bank_account_number" => ["required", "numeric"],
            "about" => ["nullable", "string", "max:500"]
        ];
    }
}
