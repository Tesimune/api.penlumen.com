<?php

namespace App\Http\Requests\Auth;

use App\Settings\Site;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|alpha|min:3|max:255',
            'last_name' => 'required|alpha|min:3|max:255',
            "username" => ["nullable","alpha_dash","min:6","max:255","unique:users,username",
                Rule::notIn(Site::reservedUsernames())
            ],
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)
                ->numbers()
                ->mixedCase()
                ->symbols()
                ->uncompromised(),
            ],
        ];
    }

    public function messages(): array
    {
        return [
          "username.not_in" => "The username already exists.",
        ];
    }
}
