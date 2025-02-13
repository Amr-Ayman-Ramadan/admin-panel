<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name"=>"required|string|min:3|max:50",
            "email"=>$this->EmailValidationUnique(),
            "type"=>"required|string|in:student,teacher",
            "birthdate"=>"required|date",
            "status"=>"required|string|in:active,inactive",
        ];
    }

    public function EmailValidationUnique()
    {
        if ($this->isMethod("PUT") || $this->isMethod("PATCH")) {
            return "required|email|unique:users,email," . $this->userId;
        }
        return "required|email|unique:users,email";
    }

}
