<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|regex:/^\+7 \d{3} \d{3} \d{2} \d{2}$/',
            'email' => 'required|email|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле имени обязательно для заполнения.',
            'phone.required' => 'Поле телефона обязательно для заполнения.',
            'phone.regex' => 'Поле телефона должно соответствовать формату: +7 999 999 99 99.',
            'email.required' => 'Поле email обязательно для заполнения.',
            'email.email' => 'Поле email должно быть действительным адресом электронной почты.',
        ];
    }
}
