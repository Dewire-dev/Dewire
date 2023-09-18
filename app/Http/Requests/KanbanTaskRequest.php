<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KanbanTaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:255',
            'date_start'     => 'date|nullable|required_with:date_end',
            'date_end'       => 'required_with:date_start',
            'scheduled_time' => 'nullable|integer',
            'members'        => 'nullable|exists:users,id',
        ];
    }
}
