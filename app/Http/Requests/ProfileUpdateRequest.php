<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // user connecté
    }

    
    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'name' => ['required', 'string', 'max:100'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],

            // ✅ mot de passe optionnel
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],

            // ✅ seulement requis si new_password est rempli
            // ✅ nullable évite de valider current_password quand vide
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
        ];
    }


    public function messages(): array
    {
        return [
            'current_password.current_password' => 'Le mot de passe actuel est incorrect.',
            'current_password.required_with' => 'Le mot de passe actuel est obligatoire pour changer le mot de passe.',
            'new_password.confirmed' => 'La confirmation du nouveau mot de passe ne correspond pas.',
        ];
    }
}