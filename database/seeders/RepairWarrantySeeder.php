<?php

namespace Database\Seeders;

use App\Models\RepairService;
use App\Models\RepairPart;
use App\Models\Warranty;
use App\Models\WarrantyClaim;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RepairWarrantySeeder extends Seeder
{
    public function run()
    {
        // 1. Ensure Technicians exist
        $techNames = [
            'Chan Vutha'  => 'chan.vutha@shop.com',
            'Kim Sovann'  => 'kim.sovann@shop.com',
            'Lay Meng'    => 'lay.meng@shop.com',
            'Srey Meas'   => 'srey.meas@shop.com',
        ];

        $techUsers = [];
        foreach ($techNames as $name => $email) {
            $techUsers[$name] = User::firstOrCreate(
                ['email' => $email],
                ['name' => $name, 'password' => bcrypt('password')]
            );
        }

        $defaultTech = $techUsers['Chan Vutha']->id;

        // 2. Ensure Customers
        $customers = Customer::pluck('id', 'name')->toArray();

        // 3. Seed Repair Services matching Mockup 1
        $repairData = [
            [
                'repair_code'          => 'RE-2025-0098',
                'customer'             => 'Sok Dara',
                'device_type'          => 'Laptop',
                'brand'                => 'ASUS',
                'model'                => 'ASUS TUF Gaming Laptop',
                'serial_number'        => 'SN123456789',
                'issue_description'    => 'Overheating and thermal throttling during heavy load',
                'diagnosis'            => 'Checking cooling system, cleaning dust, and replacing thermal paste',
                'status'               => 'Diagnosing',
                'technician'           => 'Chan Vutha',
                'created_at'           => '2025-09-10 10:32:00',
                'estimated_cost'       => 65.00,
                'estimated_completion' => '2025-09-12',
                'service_fee'          => 25.00,
                'total_cost'           => 65.00,
            ],
            [
                'repair_code'          => 'RE-2025-0097',
                'customer'             => 'Chhun Sopheak',
                'device_type'          => 'Monitor',
                'brand'                => 'Dell',
                'model'                => 'Dell 24" Monitor',
                'serial_number'        => 'SN987654321',
                'issue_description'    => 'No Display signal detected via HDMI',
                'diagnosis'            => 'Power board capacitor fault, waiting for replacement IC',
                'status'               => 'Waiting for Parts',
                'technician'           => 'Kim Sovann',
                'created_at'           => '2025-09-10 15:20:00',
                'estimated_cost'       => 45.00,
                'estimated_completion' => '2025-09-15',
                'service_fee'          => 20.00,
                'total_cost'           => 45.00,
            ],
            [
                'repair_code'          => 'RE-2025-0096',
                'customer'             => 'Vann Rith',
                'device_type'          => 'Accessory',
                'brand'                => 'Logitech',
                'model'                => 'Logitech Mouse',
                'serial_number'        => 'SN456789123',
                'issue_description'    => 'Left click double clicking intermittently',
                'diagnosis'            => 'Replacing Omron microswitch',
                'status'               => 'Repairing',
                'technician'           => 'Lay Meng',
                'created_at'           => '2025-09-09 11:45:00',
                'estimated_cost'       => 15.00,
                'estimated_completion' => '2025-09-10',
                'service_fee'          => 10.00,
                'total_cost'           => 15.00,
            ],
            [
                'repair_code'          => 'RE-2025-0095',
                'customer'             => 'Kim Sovan',
                'device_type'          => 'Component',
                'brand'                => 'MSI',
                'model'                => 'MSI RTX 4060',
                'serial_number'        => 'SN654987321',
                'issue_description'    => 'Loud fan noise and vibration at 70% speed',
                'diagnosis'            => 'Re-lubricating fan bearing and vibration dampener',
                'status'               => 'Testing',
                'technician'           => 'Srey Meas',
                'created_at'           => '2025-09-08 16:10:00',
                'estimated_cost'       => 35.00,
                'estimated_completion' => '2025-09-10',
                'service_fee'          => 20.00,
                'total_cost'           => 35.00,
            ],
            [
                'repair_code'          => 'RE-2025-0094',
                'customer'             => 'Lay Meng',
                'device_type'          => 'Printer',
                'brand'                => 'Canon',
                'model'                => 'Canon Printer',
                'serial_number'        => 'SN159753486',
                'issue_description'    => 'Frequent paper jam error message',
                'diagnosis'            => 'Replacing rubber paper roller',
                'status'               => 'Repairing',
                'technician'           => 'Lay Meng',
                'created_at'           => '2025-09-08 09:30:00',
                'estimated_cost'       => 28.00,
                'estimated_completion' => '2025-09-09',
                'service_fee'          => 15.00,
                'total_cost'           => 28.00,
            ],
            [
                'repair_code'          => 'RE-2025-0093',
                'customer'             => 'Chea Vutha',
                'device_type'          => 'Laptop',
                'brand'                => 'HP',
                'model'                => 'HP Laptop',
                'serial_number'        => 'SN753159486',
                'issue_description'    => 'Battery draining fast under 30 minutes',
                'diagnosis'            => 'Pending initial diagnosis',
                'status'               => 'Received',
                'technician'           => 'Kim Sovann',
                'created_at'           => '2025-09-07 14:20:00',
                'estimated_cost'       => 70.00,
                'estimated_completion' => '2025-09-11',
                'service_fee'          => 20.00,
                'total_cost'           => 20.00,
            ],
            [
                'repair_code'          => 'RE-2025-0092',
                'customer'             => 'San Darith',
                'device_type'          => 'Component',
                'brand'                => 'Samsung',
                'model'                => 'Samsung SSD',
                'serial_number'        => 'SN321654987',
                'issue_description'    => 'Device not detected by BIOS',
                'diagnosis'            => 'Firmware successfully reflashed and sector validated',
                'status'               => 'Completed',
                'technician'           => 'Srey Meas',
                'created_at'           => '2025-09-06 13:15:00',
                'estimated_cost'       => 30.00,
                'completed_at'         => '2025-09-07 15:00:00',
                'service_fee'          => 30.00,
                'total_cost'           => 30.00,
                'payment_status'       => 'Paid',
            ],
            [
                'repair_code'          => 'RE-2025-0091',
                'customer'             => 'Nuon Piseth',
                'device_type'          => 'Smartphone',
                'brand'                => 'Apple',
                'model'                => 'iPhone 14',
                'serial_number'        => 'SN951357246',
                'issue_description'    => 'Screen crack and digitizer touch unresponsive',
                'diagnosis'            => 'Waiting for OLED screen delivery',
                'status'               => 'Waiting for Parts',
                'technician'           => 'Lay Meng',
                'created_at'           => '2025-09-06 10:05:00',
                'estimated_cost'       => 120.00,
                'estimated_completion' => '2025-09-12',
                'service_fee'          => 30.00,
                'total_cost'           => 120.00,
            ],
            [
                'repair_code'          => 'RE-2025-0090',
                'customer'             => 'Srey Meas',
                'device_type'          => 'Laptop',
                'brand'                => 'Lenovo',
                'model'                => 'Lenovo Laptop',
                'serial_number'        => 'SN852963741',
                'issue_description'    => 'Slow performance, high disk usage 100%',
                'diagnosis'            => 'Upgraded to NVMe SSD 512GB and fresh OS installation',
                'status'               => 'Completed',
                'technician'           => 'Chan Vutha',
                'created_at'           => '2025-09-05 16:45:00',
                'estimated_cost'       => 75.00,
                'completed_at'         => '2025-09-06 18:00:00',
                'service_fee'          => 25.00,
                'total_cost'           => 75.00,
                'payment_status'       => 'Paid',
            ],
            [
                'repair_code'          => 'RE-2025-0089',
                'customer'             => 'Sok Theara',
                'device_type'          => 'Printer',
                'brand'                => 'Epson',
                'model'                => 'Epson Printer',
                'serial_number'        => 'SN741963852',
                'issue_description'    => 'Ink Error and printhead blocked',
                'diagnosis'            => 'Printhead physically damaged, customer declined repair quote',
                'status'               => 'Cancelled',
                'technician'           => 'Chan Vutha',
                'created_at'           => '2025-09-05 09:20:00',
                'estimated_cost'       => 95.00,
                'service_fee'          => 10.00,
                'total_cost'           => 10.00,
            ],
        ];

        foreach ($repairData as $r) {
            $custId = $customers[$r['customer']] ?? Customer::first()->id;
            $techId = $techUsers[$r['technician']]->id ?? $defaultTech;

            $repair = RepairService::updateOrCreate(
                ['repair_code' => $r['repair_code']],
                [
                    'customer_id'          => $custId,
                    'technician_id'        => $techId,
                    'device_type'          => $r['device_type'],
                    'brand'                => $r['brand'],
                    'model'                => $r['model'],
                    'serial_number'        => $r['serial_number'],
                    'issue_description'    => $r['issue_description'],
                    'diagnosis'            => $r['diagnosis'],
                    'status'               => $r['status'],
                    'estimated_cost'       => $r['estimated_cost'],
                    'estimated_completion' => $r['estimated_completion'] ?? now()->addDays(2),
                    'completed_at'         => $r['completed_at'] ?? null,
                    'service_fee'          => $r['service_fee'],
                    'total_cost'           => $r['total_cost'],
                    'payment_status'       => $r['payment_status'] ?? 'Unpaid',
                    'created_at'           => Carbon::parse($r['created_at']),
                ]
            );

            // Add sample repair part for RE-2025-0098
            if ($r['repair_code'] === 'RE-2025-0098') {
                $ramProd = Product::where('sku', 'KNG-RAM-010')->first();
                if ($ramProd) {
                    RepairPart::updateOrCreate(
                        ['repair_service_id' => $repair->id, 'product_id' => $ramProd->id],
                        [
                            'part_name'  => $ramProd->name,
                            'quantity'   => 1,
                            'unit_price' => $ramProd->selling_price,
                            'subtotal'   => $ramProd->selling_price,
                        ]
                    );
                    $repair->parts_total = $ramProd->selling_price;
                    $repair->total_cost = $repair->service_fee + $repair->parts_total;
                    $repair->save();
                }
            }
        }

        // 4. Seed Warranties matching Mockup 2
        $warrantyData = [
            [
                'warranty_code' => 'WAR-2025-0001',
                'product'       => 'ASUS TUF Gaming Laptop',
                'sku'           => 'ASUS-TUF-001',
                'serial'        => 'SN123456789',
                'customer'      => 'Sok Dara',
                'purchase_date' => '2025-09-10',
                'months'        => 24,
                'status'        => 'Active',
            ],
            [
                'warranty_code' => 'WAR-2025-0002',
                'product'       => 'Dell 24" Monitor',
                'sku'           => 'DELL-MON-002',
                'serial'        => 'SN987654321',
                'customer'      => 'Chhun Sopheak',
                'purchase_date' => '2025-09-08',
                'months'        => 36,
                'status'        => 'Active',
            ],
            [
                'warranty_code' => 'WAR-2025-0003',
                'product'       => 'Logitech Mouse',
                'sku'           => 'LOGI-MOU-003',
                'serial'        => 'SN456789123',
                'customer'      => 'Vann Rith',
                'purchase_date' => '2025-09-05',
                'months'        => 12,
                'status'        => 'Active',
            ],
            [
                'warranty_code' => 'WAR-2025-0004',
                'product'       => 'Razer Keyboard',
                'sku'           => 'RAZER-KEY-004',
                'serial'        => 'SN789123456',
                'customer'      => 'Kim Sovan',
                'purchase_date' => '2025-09-03',
                'months'        => 24,
                'status'        => 'Active',
            ],
            [
                'warranty_code' => 'WAR-2025-0005',
                'product'       => 'Samsung SSD 1TB',
                'sku'           => 'SAMS-SSD-005',
                'serial'        => 'SN321654987',
                'customer'      => 'Lay Meng',
                'purchase_date' => '2025-09-01',
                'months'        => 60,
                'status'        => 'Active',
            ],
            [
                'warranty_code' => 'WAR-2025-0006',
                'product'       => 'MSI RTX 4060',
                'sku'           => 'MSI-RTX-4060',
                'serial'        => 'SN654987321',
                'customer'      => 'Chea Vutha',
                'purchase_date' => '2025-08-28',
                'months'        => 36,
                'status'        => 'Active',
            ],
            [
                'warranty_code' => 'WAR-2025-0007',
                'product'       => 'Canon Printer',
                'sku'           => 'CANON-PRN-007',
                'serial'        => 'SN159753486',
                'customer'      => 'San Darith',
                'purchase_date' => '2025-08-25',
                'months'        => 12,
                'status'        => 'Expiring',
            ],
            [
                'warranty_code' => 'WAR-2025-0008',
                'product'       => 'HP Laptop',
                'sku'           => 'HP-LAP-008',
                'serial'        => 'SN753159486',
                'customer'      => 'Nuon Piseth',
                'purchase_date' => '2025-08-20',
                'months'        => 24,
                'status'        => 'Active',
            ],
            [
                'warranty_code' => 'WAR-2025-0009',
                'product'       => 'ASUS Motherboard',
                'sku'           => 'ASUS-MB-009',
                'serial'        => 'SN852741963',
                'customer'      => 'Srey Meas',
                'purchase_date' => '2025-08-18',
                'months'        => 36,
                'status'        => 'Claimed',
            ],
            [
                'warranty_code' => 'WAR-2025-0010',
                'product'       => 'Gaming Chair',
                'sku'           => 'GCHAIR-011',
                'serial'        => 'SN741852963',
                'customer'      => 'Sok Theara',
                'purchase_date' => '2025-08-15',
                'months'        => 12,
                'status'        => 'Active',
            ],
        ];

        $warrantyModels = [];
        foreach ($warrantyData as $w) {
            $prod = Product::where('sku', $w['sku'])->first();
            $custId = $customers[$w['customer']] ?? Customer::first()->id;
            $pDate = Carbon::parse($w['purchase_date']);
            $eDate = (clone $pDate)->addMonths($w['months']);

            $warrantyModels[$w['warranty_code']] = Warranty::updateOrCreate(
                ['warranty_code' => $w['warranty_code']],
                [
                    'product_id'             => $prod ? $prod->id : null,
                    'customer_id'            => $custId,
                    'serial_number'          => $w['serial'],
                    'product_name'           => $w['product'],
                    'brand'                  => $prod ? ($prod->brand->brand_name ?? 'General') : 'General',
                    'purchase_date'          => $pDate,
                    'warranty_period_months' => $w['months'],
                    'expiry_date'            => $eDate,
                    'status'                 => $w['status'],
                    'terms'                  => 'Official manufacturer warranty supported',
                ]
            );
        }

        // 5. Seed Warranty Claims matching Mockup 2
        $claimData = [
            [
                'claim_code'  => 'CLM-2025-0012',
                'war_code'    => 'WAR-2025-0006',
                'customer'    => 'Srey Meas',
                'status'      => 'In Progress',
                'date'        => '2025-09-09',
                'description' => 'Fan bearing replacement under warranty claim',
            ],
            [
                'claim_code'  => 'CLM-2025-0011',
                'war_code'    => 'WAR-2025-0002',
                'customer'    => 'Kim Sovan',
                'status'      => 'Waiting Parts',
                'date'        => '2025-09-07',
                'description' => 'Display flickering at high refresh rate',
            ],
            [
                'claim_code'  => 'CLM-2025-0010',
                'war_code'    => 'WAR-2025-0001',
                'customer'    => 'Chhun Sopheak',
                'status'      => 'Diagnosing',
                'date'        => '2025-09-05',
                'description' => 'Adapter not charging laptop',
            ],
            [
                'claim_code'  => 'CLM-2025-0009',
                'war_code'    => 'WAR-2025-0003',
                'customer'    => 'Vann Rith',
                'status'      => 'Completed',
                'date'        => '2025-09-03',
                'description' => 'Replaced new mouse unit 1-to-1 replacement',
            ],
            [
                'claim_code'  => 'CLM-2025-0008',
                'war_code'    => 'WAR-2025-0007',
                'customer'    => 'Lay Meng',
                'status'      => 'Cancelled',
                'date'        => '2025-09-01',
                'description' => 'Warranty void due to water liquid damage',
            ],
        ];

        foreach ($claimData as $c) {
            $warranty = $warrantyModels[$c['war_code']] ?? Warranty::first();
            $custId = $customers[$c['customer']] ?? $warranty->customer_id;

            WarrantyClaim::updateOrCreate(
                ['claim_code' => $c['claim_code']],
                [
                    'warranty_id'       => $warranty->id,
                    'customer_id'       => $custId,
                    'claim_date'        => Carbon::parse($c['date']),
                    'issue_description' => $c['description'],
                    'status'            => $c['status'],
                ]
            );
        }
    }
}
