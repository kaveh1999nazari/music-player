<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserHistoryCreateRequest extends FormRequest
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
            'item_type' => 'required|string',
            'item_id'   => 'required|integer',
            'action'    => 'required|string',
            'duration'  => 'nullable|integer',
        ];
    }
}
