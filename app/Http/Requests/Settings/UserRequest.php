<?php

namespace App\Http\Requests\Settings;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = isset($this->id) ? Crypt::decrypt($this->id) : '';

        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'phone'    => 'nullable|string|max:30',
            'phone'    => [
                'nullable',
                'string',
                'max:30',
                Rule::unique(User::class, 'phone')->ignore($id, 'id'),
            ],
            'password' => 'nullable|string|min:6',
        ];
    }
}
