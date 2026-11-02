<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * លក្ខខណ្ឌត្រួតពិនិត្យពេលកែប្រែ Supplier (មិនឱ្យជាន់ឈ្មោះជាមួយ Supplier ដទៃ)
     */
    public function rules()
    {
        $supplierId = $this->route('supplier') ? $this->route('supplier')->id : $this->route('supplier');

        return [
            'name'         => 'required|string|max:100|unique:suppliers,name,' . $supplierId,
            'contact_name' => 'nullable|string|max:100',
            'phone'        => 'required|string|max:30',
            'email'        => 'nullable|email|max:100',
            'address'      => 'nullable|string|max:500',
            'status'       => 'required|in:Active,Inactive',
        ];
    }
}
