<?php

namespace Modules\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'meta_description' => $this->meta_description ? array_filter(array_map('trim', explode(',', $this->meta_description))) : [],
            'meta_keyword' => $this->meta_keyword ? array_filter(array_map('trim', explode(',', $this->meta_keyword))) : [],
            'meta_robot' => $this->meta_robot ? array_filter(array_map('trim', explode(',', $this->meta_robot))) : [],
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'string|required|max:255',
            'slug' => 'string|required|max:255',
            'excerpt' => 'string|required|max:255',
            'min_to_read' => 'required|integer|max:255',
            'category' => 'integer|required|max:255',
            'tag' => 'array|required',
            'is_published' => 'boolean|required',
            'meta_description' => 'required|array',
            'meta_keyword' => 'required|array',
            'meta_robot' => 'required|array',
            'grade' => 'string|required|max:255',
            'body' => 'required'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
