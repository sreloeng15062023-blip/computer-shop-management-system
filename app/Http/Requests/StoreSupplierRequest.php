<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * អនុញ្ញាតឱ្យដំណើរការ (true)
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * លក្ខខណ្ឌត្រួតពិនិត្យពេលបន្ថែម Supplier ថ្មី
     */
    public function rules()
    {
        return [
            'name'         => 'required|string|max:100|unique:suppliers,name',
            'contact_name' => 'nullable|string|max:100',
            'phone'        => 'required|string|max:30',
            'email'        => 'nullable|email|max:100',
            'address'      => 'nullable|string|max:500',
            'status'       => 'required|in:Active,Inactive',
        ];
    }
}
