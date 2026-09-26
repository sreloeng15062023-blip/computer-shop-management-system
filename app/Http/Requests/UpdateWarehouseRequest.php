<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWarehouseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $warehouseId = $this->route('warehouse') ? ($this->route('warehouse')->id ?? $this->route('warehouse')) : null;

        return [
            'name'         => 'required|string|max:150',
            'code'         => [
                'required',
                'string',
                'max:50',
                Rule::unique('warehouses', 'code')->ignore($warehouseId),
            ],
            'location'     => 'required|string|max:255',
            'phone'        => 'nullable|string|max:30',
            'manager_name' => 'nullable|string|max:100',
            'capacity'     => 'nullable|integer|min:1',
            'status'       => 'required|in:Active,Inactive',
            'description'  => 'nullable|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'សូមបញ្ចូលឈ្មោះឃ្លាំង (Warehouse Name is required)',
            'code.required'     => 'សូមបញ្ចូលកូដសម្គាល់ឃ្លាំង (Warehouse Code is required)',
            'code.unique'       => 'កូដសម្គាល់ឃ្លាំងនេះមានរួចហើយ (Warehouse Code must be unique)',
            'location.required' => 'សូមបញ្ចូលទីតាំងឃ្លាំង (Location is required)',
            'status.required'   => 'សូមជ្រើសរើសស្ថានភាពឃ្លាំង (Status is required)',
        ];
    }
}
