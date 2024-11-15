<?php

namespace App\Http\Requests;

use App\Domain\Enums\CharacterClass;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlayerStoreRequest extends FormRequest
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
            //
            'name' => ['required', 'string'],
            'characterClass' => ['required', Rule::enum(CharacterClass::class)],
            'level' => ['required', 'integer', 'min:1', 'max:100'],
        ];
    }
}
