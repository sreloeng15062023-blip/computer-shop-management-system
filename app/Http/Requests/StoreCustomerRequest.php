<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;// អនុញ្ញាតឱ្យ User អាច Submit Form បាន
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|string|max:255',
            'phone'         => 'required|string|max:30|unique:customers,phone',
            'email'         => 'nullable|email|max:255',
            'address'       => 'nullable|string',
            'customer_type' => 'required|in:Retail,Wholesale',
            'points'        => 'nullable|integer|min:0',
            'status'        => 'required|in:Active,Inactive',
        ];
    }
}
