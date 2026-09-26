<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    /**
     * តារាង Purchase Orders ផ្ទុកទិន្នន័យប័ណ្ណបញ្ជាទិញទំនិញចូលស្តុក
     */
    protected $fillable = [
        'po_number',              // លេខកូដ PO (ឧ. PO-20260926-0001)
        'supplier_id',            // ID ក្រុមហ៊ុនផ្គត់ផ្គង់ (ភ្ជាប់ទៅតារាង suppliers)
        'user_id',                // ID បុគ្គលិកអ្នកបញ្ជាទិញ (ភ្ជាប់ទៅតារាង users)
        'order_date',             // ថ្ងៃបញ្ជាទិញ
        'expected_delivery_date', // ថ្ងៃរំពឹងថានឹងមកដល់
        'received_date',          // ថ្ងៃទទួលទំនិញចូលស្តុកពិតប្រាកដ
        'total_amount',           // តម្លៃទឹកប្រាក់សរុបនៃ PO ($)
        'status',                 // ស្ថានភាព PO ('Pending', 'Received', 'Cancelled')
        'payment_status',         // ស្ថានភាពទូទាត់ ('Unpaid', 'Partial', 'Paid')
        'notes',                  // កំណត់សម្គាល់បន្ថែម
    ];

    protected $casts = [
        'order_date'             => 'date',
        'expected_delivery_date' => 'date',
        'received_date'          => 'datetime',
        'total_amount'           => 'decimal:2',
    ];

    /**
     * ភ្ជាប់ទៅក្រុមហ៊ុនផ្គត់ផ្គង់ (Supplier)
     * Frontend អាចទាញយកឈ្មោះក្រុមហ៊ុន: $po->supplier->name
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * ភ្ជាប់ទៅអ្នកបង្កើត PO (User/Purchaser)
     * Frontend អាចទាញយកឈ្មោះអ្នកទិញ: $po->user->name
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ភ្ជាប់ទៅមុខទំនិញលម្អិតទាំងអស់ក្នុង PO នេះ (Purchase Order Details / Items)
     * Frontend ប្រើសម្រាប់ Render តារាងទំនិញក្នុង PO Slip: $po->details
     */
    public function details()
    {
        return $this->hasMany(PurchaseOrderDetail::class);
    }

    /**
     * Alias ទៅកាន់ details()
     */
    public function items()
    {
        return $this->hasMany(PurchaseOrderDetail::class);
    }

    /**
     * ភ្ជាប់ទៅប្រវត្តិប្រតិបត្តិការស្តុក (Inventory Transactions)
     * ដែលបានកើតឡើងដោយសារ PO នេះ
     */
    public function inventoryTransactions()
    {
        return $this->hasMany(InventoryTransaction::class, 'reference_id')
                    ->where('reference_type', 'PurchaseOrder');
    }
}
