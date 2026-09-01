<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'content'     => 'nullable|string',
            'thumbnail'   => 'nullable|image|max:2048',
            'tech_stack'  => 'nullable|array',
            'tech_stack.*'=> 'string',
            'github_url'  => 'nullable|url',
            'demo_url'    => 'nullable|url',
            'status'      => 'required|in:published,draft',
            'order'       => 'nullable|integer',
        ];
    }
}
