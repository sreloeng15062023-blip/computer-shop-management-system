<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_id'         => 'nullable|exists:customers,id',
            'payment_method'      => 'required|in:Cash,Card,ABA,Wing,QR,Other',
            'paid_amount'         => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'tax_percentage'      => 'nullable|numeric|min:0|max:100',
            'notes'               => 'nullable|string|max:1000',
            'items'               => 'required|array|min:1',
            'items.*.product_id'  => 'required|exists:products,id',
            'items.*.quantity'    => 'required|integer|min:1',
            'items.*.unit_price'  => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'payment_method.required'     => 'សូមជ្រើសរើសវិធីសាស្ត្រទូទាត់ (Payment method is required)',
            'payment_method.in'           => 'វិធីសាស្ត្រទូទាត់មិនត្រឹមត្រូវឡើយ (Invalid payment method)',
            'items.required'              => 'កន្ត្រកទំនិញមិនអាចទទេឡើយ (Cart cannot be empty)',
            'items.min'                   => 'ត្រូវមានទំនិញយ៉ាងហោចណាស់មួយមុខ (At least 1 product required)',
            'items.*.product_id.required' => 'សូមជ្រើសរើសទំនិញ (Product ID is required)',
            'items.*.product_id.exists'   => 'ទំនិញមិនមានក្នុងប្រព័ន្ធឡើយ (Product not found)',
            'items.*.quantity.required'   => 'សូមបញ្ចូលចំនួន (Quantity is required)',
            'items.*.quantity.min'        => 'ចំនួនត្រូវតែចាប់ពី ១ ឡើងទៅ (Quantity must be at least 1)',
            'items.*.unit_price.required' => 'សូមបញ្ចូលតម្លៃ (Unit price is required)',
        ];
    }
}
