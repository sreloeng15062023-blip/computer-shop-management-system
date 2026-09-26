<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockAdjustmentRequest extends FormRequest
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
     * ក្បួន Validation សម្រាប់ទិន្នន័យផ្ញើមកពី Modal កែសម្រួលស្តុក (Stock Adjustment) លើ Frontend
     * 
     * Frontend payload គំរូ:
     * {
     *    "product_id": 5,
     *    "adjustment_type": "subtract", // 'add' (បូកបន្ថែម), 'subtract' (ដកចេញ), 'set' (កំណត់ចំនួនថ្មីផ្ទាល់)
     *    "quantity": 3,
     *    "reason": "ទំនិញបែកបាក់ខូចខាតពេលដឹកជញ្ជូន (Damaged during display)"
     * }
     */
    public function rules()
    {
        return [
            // 1. product_id: ត្រូវតែមាន និងមានពិតប្រាកដក្នុងតារាង products
            'product_id'      => 'required|exists:products,id',

            // 2. adjustment_type: ប្រភេទនៃការកែសម្រួល (បូកបន្ថែម, ដកចេញ, ឬកំណត់ចំនួនថ្មីផ្ទាល់)
            'adjustment_type' => 'required|in:add,subtract,set',

            // 3. quantity: ចំនួនទំនិញដែលត្រូវកែសម្រួល
            'quantity'        => 'required|integer|min:0',

            // 4. reason: មូលហេតុចាំបាច់នៃការកែប្រែស្តុក (សម្រាប់ធ្វើ Audit / ចរន្តស្តុក)
            'reason'          => 'required|string|max:500',
        ];
    }

    /**
     * កំណត់សារព្រមាន (Validation Messages) ជាភាសាខ្មែរ និងអង់គ្លេសសម្រាប់បង្ហាញលើ Frontend
     */
    public function messages()
    {
        return [
            'product_id.required'      => 'សូមជ្រើសរើសទំនិញដែលត្រូវកែសម្រួលស្តុក (Product is required)',
            'product_id.exists'        => 'ទំនិញដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធឡើយ (Selected product not found)',
            'adjustment_type.required' => 'សូមជ្រើសរើសប្រភេទនៃការកែសម្រួល (Adjustment type is required: add, subtract, set)',
            'adjustment_type.in'       => 'ប្រភេទនៃការកែសម្រួលត្រូវតែជា add, subtract, ឬ set',
            'quantity.required'        => 'សូមបញ្ចូលចំនួនទំនិញ (Quantity is required)',
            'quantity.integer'         => 'ចំនួនទំនិញត្រូវតែជាចំនួនគត់ (Quantity must be an integer)',
            'quantity.min'             => 'ចំនួនទំនិញមិនអាចតូចជាង ០ ឡើយ (Quantity cannot be negative)',
            'reason.required'          => 'សូមបញ្ចូលមូលហេតុនៃការកែសម្រួលស្តុក (Reason is required for audit)',
            'reason.max'               => 'មូលហេតុមិនអាចលើសពី ៥០០ អក្សរឡើយ (Reason cannot exceed 500 characters)',
        ];
    }
}
