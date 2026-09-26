<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $categoryId = is_object($this->route('category')) ? $this->route('category')->id : ($this->route('category') ?? $this->category);

        return [
            'name'        => 'required|string|max:255|unique:categories,name,' . $categoryId,
            'slug'        => 'nullable|string|max:255|unique:categories,slug,' . $categoryId,
            'description' => 'nullable|string',
            'status'      => 'required|in:Active,Inactive',
        ];
    }
}
