<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    use HasFactory;

    /**
     * តារាង Purchase Order Details ផ្ទុកមុខទំនិញនីមួយៗក្នុងប័ណ្ណបញ្ជាទិញ
     */
    protected $fillable = [
        'purchase_order_id', // ID នៃប័ណ្ណបញ្ជាទិញ (FK -> purchase_orders)
        'product_id',        // ID នៃផលិតផលកុំព្យូទ័រ (FK -> products)
        'quantity',          // ចំនួនគ្រឿនដែលបញ្ជាទិញ
        'unit_cost',         // តម្លៃដើមទិញចូលក្នុងមួយឯកតា ($)
        'subtotal',          // តម្លៃសរុប (quantity * unit_cost)
        'received_quantity', // ចំនួនដែលបានទទួលចូលស្តុកជាក់ស្តែង
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'subtotal'  => 'decimal:2',
        'quantity'  => 'integer',
        'received_quantity' => 'integer',
    ];

    /**
     * ភ្ជាប់ទៅប័ណ្ណបញ្ជាទិញមេ (Purchase Order)
     */
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    /**
     * ភ្ជាប់ទៅផលិតផល (Product)
     * Frontend អាចទាញយកឈ្មោះទំនិញ, SKU, រូបភាព: $detail->product->name, $detail->product->sku
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
