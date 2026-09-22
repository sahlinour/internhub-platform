<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
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
        ];
    }

    /**
     * Get the validated data and map the form name to the database field.
     */
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated();

        if (isset($validated['name'])) {
            $validated['nom_complet'] = $validated['name'];
            unset($validated['name']);
        }

        return $key === null
            ? $validated
            : data_get($validated, $key, $default);
    }
}