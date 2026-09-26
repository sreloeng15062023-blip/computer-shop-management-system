<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseOrderRequest extends FormRequest
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
     * ក្បួន Validation សម្រាប់ទិន្នន័យផ្ញើមកពី Form បង្កើត Purchase Order (Frontend)
     */
    public function rules()
    {
        return [
            'supplier_id'            => 'required|exists:suppliers,id',
            'order_date'             => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:order_date',
            'status'                 => 'required|in:Pending,Received,Cancelled',
            'notes'                  => 'nullable|string|max:1000',
            'items'                  => 'required|array|min:1',
            'items.*.product_id'     => 'required|exists:products,id',
            'items.*.quantity'       => 'required|integer|min:1',
            'items.*.unit_cost'      => 'required|numeric|min:0',
        ];
    }

    /**
     * សារ Error ជាភាសាខ្មែរ និងអង់គ្លេសសម្រាប់បង្ហាញលើ Frontend
     */
    public function messages()
    {
        return [
            'supplier_id.required'            => 'សូមជ្រើសរើសក្រុមហ៊ុនផ្គត់ផ្គង់ (Supplier is required)',
            'supplier_id.exists'              => 'ក្រុមហ៊ុនផ្គត់ផ្គង់ដែលបានរើសមិនត្រឹមត្រូវឡើយ (Selected supplier does not exist)',
            'order_date.required'             => 'សូមបញ្ចូលកាលបរិច្ឆេទបញ្ជាទិញ (Order date is required)',
            'expected_delivery_date.after_or_equal' => 'ថ្ងៃរំពឹងទទួលទំនិញត្រូវតែស្មើ ឬក្រោយថ្ងៃបញ្ជាទិញ (Expected delivery must be on or after order date)',
            'status.required'                 => 'សូមជ្រើសរើសស្ថានភាពប័ណ្ណបញ្ជាទិញ (PO Status is required)',
            'items.required'                  => 'សូមជ្រើសរើសមុខទំនិញយ៉ាងហោចណាស់មួយមុខ (At least one product item is required)',
            'items.min'                       => 'ត្រូវមានទំនិញយ៉ាងហោចណាស់មួយមុខក្នុងប័ណ្ណបញ្ជាទិញ (Must include at least 1 item)',
            'items.*.product_id.required'     => 'សូមជ្រើសរើសទំនិញ (Product ID is required)',
            'items.*.product_id.exists'       => 'ទំនិញដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធឡើយ (Invalid product selected)',
            'items.*.quantity.required'       => 'សូមបញ្ចូលចំនួនទំនិញ (Quantity is required)',
            'items.*.quantity.min'            => 'ចំនួនទំនិញត្រូវតែចាប់ពី ១ ឡើងទៅ (Quantity must be at least 1)',
            'items.*.unit_cost.required'      => 'សូមបញ្ចូលតម្លៃដើមទិញចូល (Unit cost is required)',
            'items.*.unit_cost.min'           => 'តម្លៃដើមទិញចូលមិនអាចទាបជាង ០ ឡើយ (Unit cost must be at least 0)',
        ];
    }
}
