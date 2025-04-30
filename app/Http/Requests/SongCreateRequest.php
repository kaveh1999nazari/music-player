<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SongCreateRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'is_public' => 'nullable',
            'audio' => 'required|file|max:102400',
            'category_id' => 'nullable|integer',
            'category_name' => 'nullable|string|max:255',
            'artist_id' => 'nullable|integer',
            'artist_name' => 'nullable|string|max:255',
            'album_id' => 'nullable|integer',
            'album_name' => 'nullable|string|max:255',
            'release_year' => 'nullable|integer',
        ];
    }
}
