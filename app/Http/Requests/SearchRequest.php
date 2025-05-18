<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchRequest extends FormRequest
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
            'query'   => 'required|string|max:255',
            'filters' => 'nullable|array',
            'filters.*' => 'in:songs,albums,artists,playlists',
            'page'    => 'nullable|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'query.required' => 'پر کردن این فیلد اجباری است',
            'filters.array' => 'پر کردن این فیلد اجباری است',
            'filters.*' => [
                'nullable',
                Rule::in(['songs', 'albums', 'artists', 'playlists']),
            ],
            'page.integer' => 'پر کردن این فیلد اجباری است',
            'page.min' => 'صفحه اول 1 هست',
        ];
    }
}
