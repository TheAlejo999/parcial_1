<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoanRequest extends FormRequest
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
            'solicitor_name' => ['required','string','max:255'],
            'book_id' => ['required', 'integer', 'exists:books,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'solicitor_name.required' => 'El nombre del solicitante es obligatorio.',
            'solicitor_name.string' => 'El nombre del solicitante debe ser una cadena de texto.',
            'solicitor_name.max' => 'El nombre del solicitante no puede exceder los 255 caracteres.',
            'book_id.required' => 'El ID del libro es obligatorio.',
            'book_id.integer' => 'El ID del libro debe ser un número entero.',
            'book_id.exists' => 'El libro seleccionado no existe en la base de datos.',
        ];
    }
}
