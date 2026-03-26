<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLigaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id_liga' => ['required', 'string', 'max:6', 'min:2'],
            'nombre_liga' => ['required', 'string'],
            'pais_liga' => ['required', 'string'],
            'dificultad_liga' => ['required', 'integer', 'in:0,1,2,3'],
        ];
    }
}
