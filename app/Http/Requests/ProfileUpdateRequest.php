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
            'bio' => ['nullable', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'max:2048'], // 2MB

            // JobSeeker fields
            'specialty' => ['nullable', 'string', 'max:255'],
            'experience_level' => ['nullable', 'string', 'max:255'],
            'skills' => ['nullable', 'string', 'max:1000'],
            'cv_path' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'], // 5MB

            // Recruiter fields
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_size' => ['nullable', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
