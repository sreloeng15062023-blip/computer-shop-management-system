<?php

namespace Database\Seeders;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use App\Models\InventoryTransaction;
use Illuminate\Database\Seeder;

class PurchaseOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supplier1 = Supplier::first();
        $supplier2 = Supplier::skip(1)->first() ?? $supplier1;
        $user      = User::first();
        $products  = Product::take(2)->get();

        if ($products->count() === 0 || !$supplier1 || !$user) {
            return;
        }

        // 1. បង្កើត PO ទី១: ស្ថានភាព "Received"
        $poReceived = PurchaseOrder::firstOrCreate(
            ['po_number' => 'PO-20260920-0001'],
            [
                'supplier_id'            => $supplier1->id,
                'user_id'                => $user->id,
                'order_date'             => now()->subDays(6)->toDateString(),
                'expected_delivery_date' => now()->subDays(2)->toDateString(),
                'received_date'          => now()->subDays(2),
                'total_amount'           => 0,
                'status'                 => 'Received',
                'payment_status'         => 'Paid',
                'notes'                  => 'ការបញ្ជាទិញប្រចាំសប្តាហ៍ពីក្រុមហ៊ុន ' . $supplier1->name,
            ]
        );

        $totalAmount1 = 0;
        foreach ($products as $product) {
            $qty = 5;
            $unitCost = $product->cost_price > 0 ? $product->cost_price : 100.00;
            $subtotal = $qty * $unitCost;
            $totalAmount1 += $subtotal;

            PurchaseOrderDetail::create([
                'purchase_order_id' => $poReceived->id,
                'product_id'        => $product->id,
                'quantity'          => $qty,
                'unit_cost'         => $unitCost,
                'subtotal'          => $subtotal,
                'received_quantity' => $qty,
            ]);

            // កត់ត្រា Stock In ចូល inventory_transactions
            InventoryTransaction::create([
                'product_id'       => $product->id,
                'user_id'          => $user->id,
                'transaction_type' => 'Stock In',
                'quantity'         => $qty,
                'stock_before'     => $product->stock_quantity,
                'stock_after'      => $product->stock_quantity + $qty,
                'reference_type'   => 'PurchaseOrder',
                'reference_id'     => $poReceived->id,
                'reason'           => 'ទំនិញចូលស្តុកតាមប័ណ្ណបញ្ជាទិញ ' . $poReceived->po_number . ' ពីក្រុមហ៊ុន ' . $supplier1->name,
            ]);

            // បូកស្តុកលើ Product
            $product->increment('stock_quantity', $qty);
        }
        $poReceived->update(['total_amount' => $totalAmount1]);

        // =========================================================================
        // 2. បង្កើត PO ទី២: ស្ថានភាព "Pending" (កំពុងរង់ចាំទំនិញដឹកមកដល់)
        // សម្រាប់ធ្វើតេស្តប្តូរ Status ទៅ "Received" ដើម្បីផ្ទៀងផ្ទាត់ Auto Stock-In
        // =========================================================================
        $firstProduct = $products->first();
        $qty2 = 10;
        $cost2 = $firstProduct->cost_price > 0 ? $firstProduct->cost_price : 150.00;
        $subtotal2 = $qty2 * $cost2;

        $poPending = PurchaseOrder::firstOrCreate(
            ['po_number' => 'PO-20260926-0002'],
            [
                'supplier_id'            => $supplier2->id,
                'user_id'                => $user->id,
                'order_date'             => now()->toDateString(),
                'expected_delivery_date' => now()->addDays(4)->toDateString(),
                'received_date'          => null,
                'total_amount'           => $subtotal2,
                'status'                 => 'Pending',
                'payment_status'         => 'Unpaid',
                'notes'                  => 'បញ្ជាទិញបំពេញស្តុកបន្ទាន់ (Urgent Restock Order)',
            ]
        );

        PurchaseOrderDetail::create([
            'purchase_order_id' => $poPending->id,
            'product_id'        => $firstProduct->id,
            'quantity'          => $qty2,
            'unit_cost'         => $cost2,
            'subtotal'          => $subtotal2,
            'received_quantity' => 0,
        ]);

        // =========================================================================
        // 3. បង្កើតគំរូ Stock Adjustment (Step 3.3 Audit Log)
        // =========================================================================
        $currentStock = $firstProduct->fresh()->stock_quantity;
        if ($currentStock > 1) {
            $adjustQty = 1;
            $firstProduct->decrement('stock_quantity', $adjustQty);

            InventoryTransaction::create([
                'product_id'       => $firstProduct->id,
                'user_id'          => $user->id,
                'transaction_type' => 'Adjustment',
                'quantity'         => -$adjustQty,
                'stock_before'     => $currentStock,
                'stock_after'      => $currentStock - $adjustQty,
                'reference_type'   => 'StockAdjustment',
                'reference_id'     => null,
                'reason'           => 'ទំនិញបែកប្រេះស្រាំពេលដឹកជញ្ជូនចូលឃ្លាំង (Damaged during display)',
            ]);
        }
    }
}
