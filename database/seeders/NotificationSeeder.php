<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AppNotification;
use Carbon\Carbon;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        // ១. សម្អាតទិន្នន័យចាស់ៗចោលសិន កុំឱ្យជាន់លេខ ID គ្នា
        AppNotification::truncate();

        // ២. បញ្ជីទិន្នន័យគំរូ (Seed Data) គ្របដណ្តប់ទាំង ៥ ប្រភេទ និងផ្ទាំង Mockup
        $items = [
            // សារទី ១៖ លក់ចេញកុំព្យូទ័រ (Mockup ជួរទី ១)
            [
                'title'        => 'New Sale Completed',
                'message'      => "Sale #INV-2025-0098 has been completed.\nCustomer: Sok Dara\nTotal Amount: $750.00\nPayment Method: ABA",
                'type'         => 'New Sale Completed',
                'category'     => 'messages',
                'icon'         => 'fa-cart-shopping',
                'icon_color'   => 'blue',
                'action_url'   => '/invoices',
                'action_label' => 'View Sale Details',
                'is_read'      => true,
                'created_at'   => Carbon::parse('2025-09-10 10:32:00'),
            ],

            // សារទី ២៖ តម្រូវការទី ១ - Low Stock Alert
            [
                'title'        => 'Low Stock Alert',
                'message'      => 'Product "ASUS TUF Gaming Laptop" is running low (2 left in stock). Please restock soon.',
                'type'         => 'Low Stock Alert',
                'category'     => 'system_alerts',
                'icon'         => 'fa-box-open',
                'icon_color'   => 'emerald',
                'action_url'   => '/inventory',
                'action_label' => 'View Product Stock',
                'is_read'      => false,
                'created_at'   => Carbon::parse('2025-09-10 09:15:00'),
            ],

            // សារទី ៣៖ តម្រូវការទី ៣ - Repair Completion Notification
            [
                'title'        => 'Repair Service Update',
                'message'      => 'Repair #RP-2025-0045 (MacBook Pro M2 - Screen Replacement) has been completed and is ready for customer pickup.',
                'type'         => 'Repair Completion',
                'category'     => 'messages',
                'icon'         => 'fa-wrench',
                'icon_color'   => 'amber',
                'action_url'   => '/repair-service',
                'action_label' => 'View Repair Ticket',
                'is_read'      => false,
                'created_at'   => Carbon::parse('2025-09-09 16:20:00'),
            ],

            // សារទី ៤៖ តម្រូវការទី ២ - Warranty Expiry Reminder
            [
                'title'        => 'Warranty Expiry Reminder',
                'message'      => 'Warranty for "Dell XPS 15" belonging to customer "Chhun Sopheap" will expire in 7 days (2025-09-17).',
                'type'         => 'Warranty Expiry Reminder',
                'category'     => 'reminders',
                'icon'         => 'fa-shield-halved',
                'icon_color'   => 'indigo',
                'action_url'   => '/warranty',
                'action_label' => 'Review Warranty',
                'is_read'      => false,
                'created_at'   => Carbon::parse('2025-09-09 11:45:00'),
            ],

            // សារទី ៥៖ តម្រូវការទី ៥ - Purchase Order Reminder
            [
                'title'        => 'Purchase Order Received',
                'message'      => 'New purchase order #PO-2025-0045 from Dell Supplier (Total: $1,250.00) has arrived at the warehouse.',
                'type'         => 'Purchase Order Reminder',
                'category'     => 'messages',
                'icon'         => 'fa-file-invoice',
                'icon_color'   => 'rose',
                'action_url'   => '/purchases',
                'action_label' => 'Check Purchase Order',
                'is_read'      => false,
                'created_at'   => Carbon::parse('2025-09-08 15:30:00'),
            ],

            // សារទី ៦៖ បុគ្គលិកថ្មី (New Employee)
            [
                'title'        => 'New Employee Registered',
                'message'      => 'Employee "Vann Rith" has been added to the system as Technician.',
                'type'         => 'System Alert',
                'category'     => 'system_alerts',
                'icon'         => 'fa-user-plus',
                'icon_color'   => 'cyan',
                'action_url'   => '/employees',
                'action_label' => 'View Employee Profile',
                'is_read'      => true,
                'created_at'   => Carbon::parse('2025-09-08 10:12:00'),
            ],

            // សារទី ៧៖ រំលឹកការងារ (Attendance Reminder)
            [
                'title'        => 'Attendance Reminder',
                'message'      => 'Today is the last day of the work schedule (9:00 AM - 6:00 PM). Please submit attendance log.',
                'type'         => 'Reminder',
                'category'     => 'reminders',
                'icon'         => 'fa-calendar-check',
                'icon_color'   => 'blue',
                'action_url'   => '/employees',
                'action_label' => 'View Attendance',
                'is_read'      => false,
                'created_at'   => Carbon::parse('2025-09-08 08:00:00'),
            ],

            // សារទី ៨៖ ទទួលប្រាក់ (Payment Received)
            [
                'title'        => 'Payment Received',
                'message'      => 'Payment for Invoice #INV-2025-0097 via ABA KHQR ($320.00) has been verified.',
                'type'         => 'Payment Alert',
                'category'     => 'messages',
                'icon'         => 'fa-credit-card',
                'icon_color'   => 'purple',
                'action_url'   => '/invoices',
                'action_label' => 'View Invoice',
                'is_read'      => true,
                'created_at'   => Carbon::parse('2025-09-07 17:45:00'),
            ],

            // សារទី ៩៖ កែប្រែស្តុក (Stock Adjustment)
            [
                'title'        => 'Stock Adjustment',
                'message'      => 'Inventory adjustment for Product #PRD-0067 "Kingston 16GB RAM DDR4" (Qty: +5).',
                'type'         => 'Stock Adjustment',
                'category'     => 'system_alerts',
                'icon'         => 'fa-boxes-stacked',
                'icon_color'   => 'emerald',
                'action_url'   => '/inventory',
                'action_label' => 'View Stock History',
                'is_read'      => true,
                'created_at'   => Carbon::parse('2025-09-07 14:20:00'),
            ],

            // សារទី ១០៖ ថែទាំប្រព័ន្ធ (System Maintenance)
            [
                'title'        => 'System Maintenance',
                'message'      => 'System will be temporarily offline for server database backup on 2025-09-12 (10:00 PM - 12:00 AM).',
                'type'         => 'System Maintenance',
                'category'     => 'others',
                'icon'         => 'fa-bullhorn',
                'icon_color'   => 'blue',
                'action_url'   => '/settings',
                'action_label' => 'System Status',
                'is_read'      => true,
                'created_at'   => Carbon::parse('2025-09-07 09:10:00'),
            ],

            // សារទី ១១៖ តម្រូវការទី ៤ - Promotion Notification
            [
                'title'        => 'Mega Sale Promotion',
                'message'      => 'Promotion Alert: 15% discount applied on all Gaming Keyboards & Accessories until Sunday!',
                'type'         => 'Promotion Notification',
                'category'     => 'others',
                'icon'         => 'fa-tag',
                'icon_color'   => 'rose',
                'action_url'   => '/products',
                'action_label' => 'View Promoted Products',
                'is_read'      => false,
                'created_at'   => Carbon::parse('2025-09-06 10:00:00'),
            ],
        ];

        // ៣. បញ្ចូលទៅក្នុង Database ម្តងមួយៗតាមរយៈ Eloquent Model
        foreach ($items as $data) {
            AppNotification::create($data);
        }
    }
}
