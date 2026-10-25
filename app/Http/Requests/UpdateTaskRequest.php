<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'status' => 'sometimes|required|in:pendiente,in_progress,completado',
        ];
    }

    //mensajes de error personalizados
    public function messages(): array
    {
        return [
            'title.required' => 'El título es obligatorio.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado debe ser pendiente o completado.',
        ];
    }
}
