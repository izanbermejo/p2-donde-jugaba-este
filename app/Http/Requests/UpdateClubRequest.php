<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJugadorRequest extends FormRequest
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
            'id_club' => '',
            'slug_club' => ['required', 'string'],
            'nombre_club' => ['required', 'string'],
            'pais_club' => ['required', 'string'],
            'id_liga_club' => ['required', 'string', 'exists:ligas,id_liga'],
            'dificultad_club' => ['required', 'string'],
        ];
    }
}
