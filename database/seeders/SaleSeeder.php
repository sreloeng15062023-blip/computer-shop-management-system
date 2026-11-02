<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Brand;
use App\Models\User;
use App\Models\InventoryTransaction;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SaleSeeder extends Seeder
{
    public function run()
    {
        $admin = User::first();
        $userId = $admin ? $admin->id : 1;

        // 1. Ensure Categories
        $laptopCat = Category::firstOrCreate(['slug' => 'laptops'], ['name' => 'Laptops', 'description' => 'Laptops and Notebooks']);
        $monitorCat = Category::firstOrCreate(['slug' => 'monitors'], ['name' => 'Monitors', 'description' => 'Monitors and Displays']);
        $accCat = Category::firstOrCreate(['slug' => 'accessories'], ['name' => 'Accessories', 'description' => 'Keyboards, Mice & Peripherals']);
        $compCat = Category::firstOrCreate(['slug' => 'components'], ['name' => 'Components', 'description' => 'PC Hardware Components']);
        $printCat = Category::firstOrCreate(['slug' => 'printers'], ['name' => 'Printers', 'description' => 'Printers and Scanners']);
        $otherCat = Category::firstOrCreate(['slug' => 'others'], ['name' => 'Others', 'description' => 'Furniture and Accessories']);

        $asusBrand = Brand::firstOrCreate(['brand_name' => 'ASUS'], ['country' => 'Taiwan']);
        $dellBrand = Brand::firstOrCreate(['brand_name' => 'Dell'], ['country' => 'USA']);
        $logiBrand = Brand::firstOrCreate(['brand_name' => 'Logitech'], ['country' => 'Switzerland']);
        $razerBrand = Brand::firstOrCreate(['brand_name' => 'Razer'], ['country' => 'USA']);
        $samsungBrand = Brand::firstOrCreate(['brand_name' => 'Samsung'], ['country' => 'South Korea']);
        $msiBrand = Brand::firstOrCreate(['brand_name' => 'MSI'], ['country' => 'Taiwan']);

        // 2. Ensure Products matching Mockup 2
        $productsData = [
            [
                'name' => 'ASUS TUF Gaming Laptop',
                'sku' => 'ASUS-TUF-001',
                'barcode' => '880921001001',
                'cost_price' => 620.00,
                'selling_price' => 750.00,
                'stock_quantity' => 12,
                'min_stock_alert' => 3,
                'category_id' => $laptopCat->id,
                'brand_id' => $asusBrand->id,
                'thumbnail' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?auto=format&fit=crop&w=300&h=300&q=80',
                'status' => 'In Stock',
            ],
            [
                'name' => 'Dell 24" Monitor',
                'sku' => 'DELL-MON-002',
                'barcode' => '880921001002',
                'cost_price' => 140.00,
                'selling_price' => 180.00,
                'stock_quantity' => 20,
                'min_stock_alert' => 5,
                'category_id' => $monitorCat->id,
                'brand_id' => $dellBrand->id,
                'thumbnail' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=300&h=300&q=80',
                'status' => 'In Stock',
            ],
            [
                'name' => 'Logitech Mouse',
                'sku' => 'LOGI-MOU-003',
                'barcode' => '880921001003',
                'cost_price' => 18.00,
                'selling_price' => 25.00,
                'stock_quantity' => 45,
                'min_stock_alert' => 10,
                'category_id' => $accCat->id,
                'brand_id' => $logiBrand->id,
                'thumbnail' => 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?auto=format&fit=crop&w=300&h=300&q=80',
                'status' => 'In Stock',
            ],
            [
                'name' => 'Razer Keyboard',
                'sku' => 'RAZER-KEY-004',
                'barcode' => '880921001004',
                'cost_price' => 90.00,
                'selling_price' => 120.00,
                'stock_quantity' => 2,
                'min_stock_alert' => 5,
                'category_id' => $accCat->id,
                'brand_id' => $razerBrand->id,
                'thumbnail' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=300&h=300&q=80',
                'status' => 'Low Stock',
            ],
            [
                'name' => 'Samsung SSD 1TB',
                'sku' => 'SAMS-SSD-005',
                'barcode' => '880921001005',
                'cost_price' => 70.00,
                'selling_price' => 95.00,
                'stock_quantity' => 30,
                'min_stock_alert' => 5,
                'category_id' => $compCat->id,
                'brand_id' => $samsungBrand->id,
                'thumbnail' => 'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?auto=format&fit=crop&w=300&h=300&q=80',
                'status' => 'In Stock',
            ],
            [
                'name' => 'MSI RTX 4060',
                'sku' => 'MSI-RTX-4060',
                'barcode' => '880921001006',
                'cost_price' => 260.00,
                'selling_price' => 320.00,
                'stock_quantity' => 8,
                'min_stock_alert' => 3,
                'category_id' => $compCat->id,
                'brand_id' => $msiBrand->id,
                'thumbnail' => 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?auto=format&fit=crop&w=300&h=300&q=80',
                'status' => 'In Stock',
            ],
            [
                'name' => 'Canon Printer',
                'sku' => 'CANON-PRN-007',
                'barcode' => '880921001007',
                'cost_price' => 110.00,
                'selling_price' => 150.00,
                'stock_quantity' => 10,
                'min_stock_alert' => 2,
                'category_id' => $printCat->id,
                'brand_id' => $asusBrand->id,
                'thumbnail' => 'https://images.unsplash.com/photo-1612815154858-60aa4c59eaa6?auto=format&fit=crop&w=300&h=300&q=80',
                'status' => 'In Stock',
            ],
            [
                'name' => 'HP Laptop',
                'sku' => 'HP-LAP-008',
                'barcode' => '880921001008',
                'cost_price' => 540.00,
                'selling_price' => 680.00,
                'stock_quantity' => 6,
                'min_stock_alert' => 2,
                'category_id' => $laptopCat->id,
                'brand_id' => $dellBrand->id,
                'thumbnail' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=300&h=300&q=80',
                'status' => 'In Stock',
            ],
            [
                'name' => 'ASUS Motherboard',
                'sku' => 'ASUS-MB-009',
                'barcode' => '880921001009',
                'cost_price' => 165.00,
                'selling_price' => 210.00,
                'stock_quantity' => 14,
                'min_stock_alert' => 3,
                'category_id' => $compCat->id,
                'brand_id' => $asusBrand->id,
                'thumbnail' => 'https://images.unsplash.com/photo-1555680202-c86f0e12f086?auto=format&fit=crop&w=300&h=300&q=80',
                'status' => 'In Stock',
            ],
            [
                'name' => 'Kingston RAM 16GB',
                'sku' => 'KNG-RAM-010',
                'barcode' => '880921001010',
                'cost_price' => 32.00,
                'selling_price' => 45.00,
                'stock_quantity' => 40,
                'min_stock_alert' => 10,
                'category_id' => $compCat->id,
                'brand_id' => $asusBrand->id,
                'thumbnail' => 'https://images.unsplash.com/photo-1562976540-1502c2145186?auto=format&fit=crop&w=300&h=300&q=80',
                'status' => 'In Stock',
            ],
            [
                'name' => 'Gaming Chair',
                'sku' => 'GCHAIR-011',
                'barcode' => '880921001011',
                'cost_price' => 130.00,
                'selling_price' => 180.00,
                'stock_quantity' => 12,
                'min_stock_alert' => 2,
                'category_id' => $otherCat->id,
                'brand_id' => $razerBrand->id,
                'thumbnail' => 'https://images.unsplash.com/photo-1598550476439-6847785fcea6?auto=format&fit=crop&w=300&h=300&q=80',
                'status' => 'In Stock',
            ],
            [
                'name' => 'Webcam',
                'sku' => 'WEBCAM-012',
                'barcode' => '880921001012',
                'cost_price' => 28.00,
                'selling_price' => 40.00,
                'stock_quantity' => 25,
                'min_stock_alert' => 5,
                'category_id' => $accCat->id,
                'brand_id' => $logiBrand->id,
                'thumbnail' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=300&h=300&q=80',
                'status' => 'In Stock',
            ],
        ];

        foreach ($productsData as $pData) {
            Product::updateOrCreate(['sku' => $pData['sku']], $pData);
        }

        // 3. Ensure Customers matching Mockup 1 & 2
        $customersData = [
            ['name' => 'Sok Dara', 'phone' => '+855 12 345 678', 'email' => 'sokdara@gmail.com', 'points' => 150, 'customer_type' => 'Retail', 'status' => 'Active'],
            ['name' => 'Chhun Sopheak', 'phone' => '+855 98 765 432', 'email' => 'sopheak@gmail.com', 'points' => 300, 'customer_type' => 'Retail', 'status' => 'Active'],
            ['name' => 'Vann Rith', 'phone' => '+855 10 223 344', 'email' => 'vannrith@gmail.com', 'points' => 50, 'customer_type' => 'Retail', 'status' => 'Active'],
            ['name' => 'Kim Sovan', 'phone' => '+855 77 112 233', 'email' => 'sovan@gmail.com', 'points' => 420, 'customer_type' => 'Wholesale', 'status' => 'Active'],
            ['name' => 'Lay Meng', 'phone' => '+855 12 998 877', 'email' => 'laymeng@gmail.com', 'points' => 10, 'customer_type' => 'Retail', 'status' => 'Active'],
            ['name' => 'Chea Vutha', 'phone' => '+855 89 556 677', 'email' => 'vutha@gmail.com', 'points' => 800, 'customer_type' => 'Wholesale', 'status' => 'Active'],
            ['name' => 'San Darith', 'phone' => '+855 97 665 544', 'email' => 'darith@gmail.com', 'points' => 90, 'customer_type' => 'Retail', 'status' => 'Active'],
            ['name' => 'Nuon Piseth', 'phone' => '+855 16 332 211', 'email' => 'piseth@gmail.com', 'points' => 60, 'customer_type' => 'Retail', 'status' => 'Active'],
            ['name' => 'Srey Meas', 'phone' => '+855 92 443 322', 'email' => 'sreymeas@gmail.com', 'points' => 120, 'customer_type' => 'Retail', 'status' => 'Active'],
            ['name' => 'Sok Theara', 'phone' => '+855 88 776 655', 'email' => 'theara@gmail.com', 'points' => 210, 'customer_type' => 'Retail', 'status' => 'Active'],
        ];

        $customerModels = [];
        foreach ($customersData as $c) {
            $customerModels[$c['name']] = Customer::updateOrCreate(['name' => $c['name']], $c);
        }

        // 4. Seed Sales, Details, Invoices, Payments matching Mockup 1 list
        $salesMock = [
            [
                'invoice_no' => 'INV-2025-0098',
                'sale_no'    => 'POS-2025-0098',
                'customer'   => 'Sok Dara',
                'date'       => '2025-09-10 10:32:00',
                'amount'     => 750.00,
                'method'     => 'Cash',
                'status'     => 'Paid',
                'items'      => [
                    ['sku' => 'ASUS-TUF-001', 'qty' => 1, 'price' => 750.00]
                ]
            ],
            [
                'invoice_no' => 'INV-2025-0097',
                'sale_no'    => 'POS-2025-0097',
                'customer'   => 'Chhun Sopheak',
                'date'       => '2025-09-10 09:15:00',
                'amount'     => 450.00,
                'method'     => 'Card',
                'status'     => 'Paid',
                'items'      => [
                    ['sku' => 'DELL-MON-002', 'qty' => 2, 'price' => 180.00],
                    ['sku' => 'SAMS-SSD-005', 'qty' => 1, 'price' => 90.00],
                ]
            ],
            [
                'invoice_no' => 'INV-2025-0096',
                'sale_no'    => 'POS-2025-0096',
                'customer'   => 'Vann Rith',
                'date'       => '2025-09-09 16:45:00',
                'amount'     => 320.00,
                'method'     => 'ABA',
                'status'     => 'Paid',
                'items'      => [
                    ['sku' => 'MSI-RTX-4060', 'qty' => 1, 'price' => 320.00]
                ]
            ],
            [
                'invoice_no' => 'INV-2025-0095',
                'sale_no'    => 'POS-2025-0095',
                'customer'   => 'Kim Sovan',
                'date'       => '2025-09-09 14:20:00',
                'amount'     => 680.00,
                'method'     => 'Wing',
                'status'     => 'Paid',
                'items'      => [
                    ['sku' => 'HP-LAP-008', 'qty' => 1, 'price' => 680.00]
                ]
            ],
            [
                'invoice_no' => 'INV-2025-0094',
                'sale_no'    => 'POS-2025-0094',
                'customer'   => 'Lay Meng',
                'date'       => '2025-09-09 11:10:00',
                'amount'     => 120.00,
                'method'     => 'Cash',
                'status'     => 'Paid',
                'items'      => [
                    ['sku' => 'RAZER-KEY-004', 'qty' => 1, 'price' => 120.00]
                ]
            ],
            [
                'invoice_no' => 'INV-2025-0093',
                'sale_no'    => 'POS-2025-0093',
                'customer'   => 'Chea Vutha',
                'date'       => '2025-09-08 15:30:00',
                'amount'     => 1200.00,
                'method'     => 'Card',
                'status'     => 'Paid',
                'items'      => [
                    ['sku' => 'ASUS-TUF-001', 'qty' => 1, 'price' => 750.00],
                    ['sku' => 'MSI-RTX-4060', 'qty' => 1, 'price' => 320.00],
                    ['sku' => 'GCHAIR-011',   'qty' => 1, 'price' => 130.00]
                ]
            ],
            [
                'invoice_no' => 'INV-2025-0092',
                'sale_no'    => 'POS-2025-0092',
                'customer'   => 'San Darith',
                'date'       => '2025-09-08 10:05:00',
                'amount'     => 750.00,
                'method'     => 'ABA',
                'status'     => 'Pending',
                'items'      => [
                    ['sku' => 'ASUS-TUF-001', 'qty' => 1, 'price' => 750.00]
                ]
            ],
            [
                'invoice_no' => 'INV-2025-0091',
                'sale_no'    => 'POS-2025-0091',
                'customer'   => 'Nuon Piseth',
                'date'       => '2025-09-07 17:40:00',
                'amount'     => 580.00,
                'method'     => 'Cash',
                'status'     => 'Paid',
                'items'      => [
                    ['sku' => 'ASUS-MB-009', 'qty' => 2, 'price' => 210.00],
                    ['sku' => 'CANON-PRN-007', 'qty' => 1, 'price' => 160.00]
                ]
            ],
            [
                'invoice_no' => 'INV-2025-0090',
                'sale_no'    => 'POS-2025-0090',
                'customer'   => 'Srey Meas',
                'date'       => '2025-09-07 14:20:00',
                'amount'     => 420.00,
                'method'     => 'Card',
                'status'     => 'Paid',
                'items'      => [
                    ['sku' => 'DELL-MON-002', 'qty' => 1, 'price' => 180.00],
                    ['sku' => 'GCHAIR-011', 'qty' => 1, 'price' => 180.00],
                    ['sku' => 'WEBCAM-012', 'qty' => 1, 'price' => 60.00]
                ]
            ],
            [
                'invoice_no' => 'INV-2025-0089',
                'sale_no'    => 'POS-2025-0089',
                'customer'   => 'Sok Theara',
                'date'       => '2025-09-06 11:50:00',
                'amount'     => 960.00,
                'method'     => 'Wing',
                'status'     => 'Cancelled',
                'items'      => [
                    ['sku' => 'HP-LAP-008', 'qty' => 1, 'price' => 680.00],
                    ['sku' => 'DELL-MON-002', 'qty' => 1, 'price' => 180.00],
                    ['sku' => 'RAZER-KEY-004', 'qty' => 1, 'price' => 100.00]
                ]
            ],
        ];

        foreach ($salesMock as $mock) {
            $customer = $customerModels[$mock['customer']] ?? null;
            $customerId = $customer ? $customer->id : null;
            $saleDate = Carbon::parse($mock['date']);

            $subtotal = $mock['amount'];
            $taxAmount = round($subtotal * 0.10, 2);
            $totalAmount = $subtotal + $taxAmount;
            $isPaid = $mock['status'] === 'Paid';
            $isPending = $mock['status'] === 'Pending';
            $paidAmount = $isPaid ? $totalAmount : ($isPending ? 470.00 : 0);
            $balanceDue = max(0, $totalAmount - $paidAmount);

            // 1. Create Sale
            $sale = Sale::updateOrCreate(
                ['sale_number' => $mock['sale_no']],
                [
                    'customer_id'         => $customerId,
                    'user_id'             => $userId,
                    'sale_date'           => $saleDate,
                    'subtotal'            => $subtotal,
                    'discount_percentage' => 0,
                    'discount_amount'     => 0,
                    'tax_percentage'      => 10,
                    'tax_amount'          => $taxAmount,
                    'total_amount'        => $totalAmount,
                    'paid_amount'         => $paidAmount,
                    'change_amount'       => 0,
                    'payment_method'      => $mock['method'],
                    'payment_status'      => $isPaid ? 'Paid' : ($isPending ? 'Partial' : 'Pending'),
                    'status'              => $mock['status'] === 'Cancelled' ? 'Cancelled' : 'Completed',
                    'notes'               => 'Seeded transaction',
                ]
            );

            // 2. Create Sale Details
            foreach ($mock['items'] as $item) {
                $prod = Product::where('sku', $item['sku'])->first();
                if ($prod) {
                    SaleDetail::updateOrCreate(
                        [
                            'sale_id'    => $sale->id,
                            'product_id' => $prod->id,
                        ],
                        [
                            'quantity'        => $item['qty'],
                            'unit_price'      => $item['price'],
                            'subtotal'        => $item['qty'] * $item['price'],
                            'warranty_months' => 12,
                        ]
                    );
                }
            }

            // 3. Create Invoice
            $invoice = Invoice::updateOrCreate(
                ['invoice_number' => $mock['invoice_no']],
                [
                    'sale_id'         => $sale->id,
                    'customer_id'     => $customerId,
                    'user_id'         => $userId,
                    'invoice_date'    => $saleDate,
                    'due_date'        => (clone $saleDate)->addDays(14),
                    'subtotal'        => $subtotal,
                    'discount_amount' => 0,
                    'tax_amount'      => $taxAmount,
                    'total_amount'    => $totalAmount,
                    'paid_amount'     => $paidAmount,
                    'balance_due'     => $balanceDue,
                    'payment_method'  => $mock['method'],
                    'status'          => $mock['status'],
                    'notes'           => 'Computer Shop Purchase Invoice',
                ]
            );

            // 4. Create Payment if paid > 0
            if ($paidAmount > 0) {
                Payment::updateOrCreate(
                    ['payment_number' => 'PAY-' . substr($mock['invoice_no'], 4)],
                    [
                        'sale_id'               => $sale->id,
                        'invoice_id'            => $invoice->id,
                        'customer_id'           => $customerId,
                        'user_id'               => $userId,
                        'amount'                => $paidAmount,
                        'payment_method'        => $mock['method'],
                        'payment_date'          => $saleDate,
                        'transaction_reference' => $mock['method'] === 'ABA' ? 'ABA-TRX-2025' . rand(1000, 9999) : null,
                        'status'                => 'Completed',
                        'notes'                 => 'Counter settlement',
                    ]
                );
            }
        }
    }
}
