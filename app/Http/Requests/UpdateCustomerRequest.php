<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
        // ទាញយក ID របស់ Customer ដែលកំពុងកែប្រែ (Update) ចេញពី URL (Route Parameter)
        // - ប្រសិនបើ Laravel ចាប់បានជា Model Object នោះយើងយក ->id
        // - ប្រសិនបើ Laravel ចាប់បានជាលេខ ID ផ្ទាល់ នោះយើងយកតម្លៃនោះតែម្តង
        $customerId = is_object($this->route('customer')) ? $this->route('customer')->id : ($this->route('customer') ?? $this->customer);

        return [
            'name'          => 'required|string|max:255',
            // 'unique:customers,phone,' . $customerId
            // មានន័យថា៖ ពិនិត្យលេខទូរស័ព្ទមិនឱ្យស្ទួនជាមួយ Customer ផ្សេងទៀតឡើយ
            // ប៉ុន្តែអនុញ្ញាតឱ្យរក្សាលេខទូរស័ព្ទដដែលរបស់ Customer ខ្លួនឯងដែលកំពុងកែប្រែ (មិនរាប់បញ្ចូល ID របស់ខ្លួនឯងឡើយ)
            'phone'         => 'required|string|max:30|unique:customers,phone,' . $customerId,
            'email'         => 'nullable|email|max:255',
            'address'       => 'nullable|string',
            'customer_type' => 'required|in:Retail,Wholesale',
            'points'        => 'nullable|integer|min:0',
            'status'        => 'required|in:Active,Inactive',
        ];
    }
}
