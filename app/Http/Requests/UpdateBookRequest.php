<?php

namespace App\Http\Requests;

use App\Enums\BookStatus;
use App\Models\Book;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('update', $this->book);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "title" => ["nullable", "string", "max:150"],
            "status" => ["nullable", Rule::enum(BookStatus::class)],
            "content" => ["required_if:status,".BookStatus::PUBLISHED->value, "string", "max:5000"],
            "description" => ["nullable", "string", "max:255"],
            "cover" => [
                "required_if:status,".BookStatus::PUBLISHED->value,
                "file",
                "mimes:jpg,jpeg,png",
                "max:2000"
            ],
        ];
    }
}
