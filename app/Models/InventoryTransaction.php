<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;

    /**
     * តារាង Inventory Transactions កត់ត្រារាល់ចរន្តស្តុកចេញ-ចូល និងការកែតម្រូវ
     */
    protected $fillable = [
        'product_id',       // ID នៃទំនិញ (FK -> products)
        'user_id',          // ID បុគ្គលិកដែលធ្វើប្រតិបត្តិការ (FK -> users)
        'transaction_type', // ប្រភេទប្រតិបត្តិការ ('Stock In', 'Stock Out', 'Adjustment', 'Sale', 'Return')
        'quantity',         // ចំនួនប្រែប្រួល (+ សម្រាប់ចូល, - សម្រាប់ចេញ)
        'stock_before',     // ចំនួនស្តុកនៅសល់មុនប្រតិបត្តិការ
        'stock_after',      // ចំនួនស្តុកនៅសល់ក្រោយប្រតិបត្តិការ
        'reference_type',   // ប្រភេទឯកសារយោង ('PurchaseOrder', 'StockAdjustment', 'Sale')
        'reference_id',     // ID ឯកសារយោង
        'reason',           // មូលហេតុនៃការកែប្រែស្តុក
    ];

    protected $casts = [
        'quantity'     => 'integer',
        'stock_before' => 'integer',
        'stock_after'  => 'integer',
    ];

    /**
     * ភ្ជាប់ទៅផលិតផល (Product)
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * ភ្ជាប់ទៅបុគ្គលិកដែលធ្វើប្រតិបត្តិការ (User)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ភ្ជាប់ទៅ Purchase Order (ប្រសិនបើ reference_type == 'PurchaseOrder')
     */
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'reference_id');
    }

    /**
     * Accessor សម្រាប់ Frontend compatibility (quantity_change)
     */
    public function getQuantityChangeAttribute()
    {
        return $this->quantity;
    }
}
