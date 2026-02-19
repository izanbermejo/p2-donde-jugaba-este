<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorejugadorRequest extends FormRequest
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
            'id_jugador' => ['required', 'integer'],
            'slug_jugador' => ['required', 'string'],
            'nombre_jugador' => ['required', 'string'],
            'fecha_nacimiento_jugador' => ['required', 'date'],
            'pais_jugador' => ['required', 'string', 'exists:paises,id_pais'],
            'posicion_jugador' => ['required', 'string'],
            'club_actual_jugador' => ['required', 'string'],
        ];
    }
}
