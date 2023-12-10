<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReminderUpdateRequest extends BaseFormRequest
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id'=>$this->route()->parameters()['id'] ?? null
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:reminders,id',
            'title' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:255',
            'remind_at' => 'nullable|integer|date_format:U',
            'event_at' => 'nullable|integer|date_format:U'
        ];
    }
}
