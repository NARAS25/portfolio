<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExperienceRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'type'         => 'required|in:work,education,organization',
            'title'        => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'location'     => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'start_date'   => 'required|date',
            'end_date'     => 'nullable|date|after:start_date',
            'is_current'   => 'boolean',
            'order'        => 'nullable|integer',
        ];
    }
}
