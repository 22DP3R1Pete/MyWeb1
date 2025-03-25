<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'height' => ['nullable', 'numeric', 'between:50,250'],
            'weight' => ['nullable', 'numeric', 'between:20,300'],
            'birth_year' => ['nullable', 'integer', 'between:1900,' . date('Y')],
            'fitness_goals' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
