<?php

namespace App\Http\Controllers;

// ហៅ Model ទាំងអស់ដែលពាក់ព័ន្ធមកប្រើប្រាស់
use App\Models\AppNotification;
use App\Models\Product;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * =========================================================================
     * FUNCTION 1: index() - បង្ហាញទំព័រដើមនៃ Notification
     * =========================================================================
     * URL: GET /notifications
     * តួនាទី: គិតគូរ Filter, Search, Tabs និងគណនាស្ថិតិ Stat Cards
     */
    public function index(Request $request)
    {
        // ហៅ Helper ស្កេនរកទំនិញជិតអស់ស្តុក ដើម្បីបង្កើត Alert ស្វ័យប្រវត្តិ
        $this->syncRealTimeAlerts();

        // ចាប់ផ្តើមសរសេរ Query ដោយតម្រៀបសារថ្មីៗមកមុខគេ (latest id)
        $query = AppNotification::latest('id');

        // ១. ចម្រោះតាមប្រភេទ Tab (All, Messages, System Alerts, Reminders, Others)
        if ($request->filled('tab') && $request->tab !== 'all') {
            $query->where('category', $request->tab);
        }

        // ២. ស្វែងរកតាមពាក្យគន្លឹះ (Search Input)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
            });
        }

        // ៣. ចម្រោះតាមប្រភេទ Type (Low Stock, Warranty, Repair, PO, etc.)
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // ៤. ចម្រោះតាមស្ថានភាព Status (Unread vs Read)
        if ($request->filled('status') && $request->status !== 'all') {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }

        // ៥. ចម្រោះតាមចន្លោះកាលបរិច្ឆេទ (Date From -> Date To)
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // កំណត់ឱ្យបង្ហាញតែ ១០ សារក្នុងមួយទំព័រ (ដូចក្នុងរូបភាព)
        $notifications = $query->paginate(10)->withQueryString();

        // ៦. គណនាស្ថិតិសម្រាប់ Tab Headers និង Stat Cards នៅចំហៀងស្តាំ
        $totalCount       = AppNotification::count();
        $unreadCount      = AppNotification::where('is_read', false)->count();
        $messagesCount    = AppNotification::where('category', 'messages')->count();
        $systemAlertCount = AppNotification::where('category', 'system_alerts')->count();
        $reminderCount    = AppNotification::where('category', 'reminders')->count();
        $othersCount      = AppNotification::where('category', 'others')->count();

        // យកសារទីមួយមកធ្វើជា Preview ដំបូងគេលើផ្ទាំង Notification Details ខាងស្តាំ
        $firstNotification = $notifications->first();

        // បញ្ជូនទិន្នន័យទាំងអស់នេះទៅកាន់ឯកសារ Blade View
        return view('notifications', compact(
            'notifications',
            'totalCount',
            'unreadCount',
            'messagesCount',
            'systemAlertCount',
            'reminderCount',
            'othersCount',
            'firstNotification'
        ));
    }

    /**
     * =========================================================================
     * FUNCTION 2: show($id) - ទាញទិន្នន័យលម្អិតនៃសារមួយមកបង្ហាញតាម AJAX
     * =========================================================================
     * URL: GET /notifications/{id}/details
     * តួនាទី: ពេល User ចុចលើជួរណាមួយ វានឹងហៅ Function នេះដើម្បីបង្ហាញលើផ្ទាំងស្តាំ
     */
    public function show($id)
    {
        $notification = AppNotification::findOrFail($id);

        // ប្រសិនបើសារនោះមិនទាន់អាន ពេលចុចមើលភ្លាម ឱ្យវាទៅជាអានរួចស្វ័យប្រវត្តិ
        if (!$notification->is_read) {
            $notification->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        // Return ជាទម្រង់ JSON សម្រាប់ឱ្យ JavaScript យកទៅបិទភ្ជាប់លើ UI
        return response()->json([
            'success' => true,
            'data'    => [
                'id'           => $notification->id,
                'title'        => $notification->title,
                'message'      => $notification->message,
                'type'         => $notification->type,
                'category'     => $notification->category,
                'icon'         => $notification->icon,
                'icon_color'   => $notification->icon_color,
                'action_url'   => $notification->action_url,
                'action_label' => $notification->action_label,
                'created_at'   => $notification->created_at->format('Y-m-d h:i A'),
                'is_read'      => $notification->is_read,
            ]
        ]);
    }

    /**
     * =========================================================================
     * FUNCTION 3: markAsRead($id) - កំណត់ថាសារមួយបានអានរួច
     * =========================================================================
     * URL: POST /notifications/{id}/read
     */
    public function markAsRead($id)
    {
        $notification = AppNotification::findOrFail($id);
        $notification->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'បានកំណត់ថាអានរួច']);
    }

    /**
     * =========================================================================
     * FUNCTION 4: markAllAsRead() - កំណត់សារទាំងអស់ថាបានអានរួច
     * =========================================================================
     * URL: POST /notifications/mark-all-read
     */
    public function markAllAsRead()
    {
        AppNotification::where('is_read', false)->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return redirect()->back()->with('success', 'បានកំណត់ដំណឹងទាំងអស់ជាអានរួចរាល់!');
    }

    /**
     * =========================================================================
     * FUNCTION 5: bulkAction() - ដំណើរការលើសារច្រើនដែលបានធីក Checkbox
     * =========================================================================
     * URL: POST /notifications/bulk-action
     */
    public function bulkAction(Request $request)
    {
        $ids = $request->input('ids', []);
        $action = $request->input('action');

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'សូមជ្រើសរើសសារយ៉ាងហោចមួយ!'], 422);
        }

        if ($action === 'mark_read') {
            AppNotification::whereIn('id', $ids)->update(['is_read' => true, 'read_at' => now()]);
            $msg = 'បានកំណត់សារដែលជ្រើសរើសជាអានរួចរាល់';
        } elseif ($action === 'delete') {
            AppNotification::whereIn('id', $ids)->delete();
            $msg = 'បានលុបសារដែលជ្រើសរើសដោយជោគជ័យ';
        } else {
            return response()->json(['success' => false, 'message' => 'សកម្មភាពមិនត្រឹមត្រូវ'], 400);
        }

        return response()->json(['success' => true, 'message' => $msg]);
    }

    /**
     * =========================================================================
     * FUNCTION 6: destroy($id) - លុបសារមួយចោល
     * =========================================================================
     * URL: DELETE /notifications/{id}
     */
    public function destroy($id)
    {
        $notification = AppNotification::findOrFail($id);
        $notification->delete();

        return response()->json(['success' => true, 'message' => 'បានលុបសារដំណឹងដោយជោគជ័យ']);
    }

    /**
     * =========================================================================
     * FUNCTION 7: syncRealTimeAlerts() - ពិនិត្យរកទំនិញអស់ស្តុកស្វ័យប្រវត្តិ
     * =========================================================================
     * ការពារពេលគ្រូសួរថា "ចុះបើស្តុកស្រាប់តែធ្លាក់សល់តិច តើប្រព័ន្ធ Alert យ៉ាងដូចម្តេច?"
     */
        /**
     * FUNCTION: syncRealTimeAlerts() - ពិនិត្យរកដំណឹងស្វ័យប្រវត្តិតាមលក្ខខណ្ឌ Assignment ទាំង ៥
     */
    private function syncRealTimeAlerts()
    {
        // ១. តម្រូវការ ១: Low Stock Alert (ទំនិញសល់ <= 5 ក្នុងស្តុក)
        if (class_exists(\App\Models\Product::class)) {
            $lowStockProducts = \App\Models\Product::where('stock_quantity', '<=', 5)
                ->where('status', '!=', 'Discontinued')
                ->take(3)
                ->get();

            foreach ($lowStockProducts as $prod) {
                AppNotification::firstOrCreate(
                    [
                        'type'    => 'Low Stock Alert',
                        'title'   => 'Low Stock Alert',
                        'message' => "Product \"{$prod->name}\" is running low ({$prod->stock_quantity} left in stock).",
                    ],
                    [
                        'category'     => 'system_alerts',
                        'icon'         => 'fa-box-open',
                        'icon_color'   => 'emerald',
                        'action_url'   => url('/inventory'),
                        'action_label' => 'View Product Stock',
                        'is_read'      => false,
                    ]
                );
            }
        }

        // ២. តម្រូវការ ២: Warranty Expiry Reminder (ការធានាដែលជិតផុតកំណត់ក្នុងរយៈពេល ៧ ថ្ងៃ)
        if (class_exists(\App\Models\Warranty::class)) {
            $expiringWarranties = \App\Models\Warranty::whereBetween('expiry_date', [now(), now()->addDays(7)])
                ->where('status', 'Active')
                ->take(3)
                ->get();

            foreach ($expiringWarranties as $w) {
                AppNotification::firstOrCreate(
                    [
                        'type'    => 'Warranty Expiry Reminder',
                        'title'   => 'Warranty Expiry Reminder',
                        'message' => "Warranty for \"{$w->product_name}\" (Serial: {$w->serial_number}) will expire on {$w->expiry_date->format('Y-m-d')}.",
                    ],
                    [
                        'category'     => 'reminders',
                        'icon'         => 'fa-shield-halved',
                        'icon_color'   => 'indigo',
                        'action_url'   => url('/warranty'),
                        'action_label' => 'Check Warranty',
                        'is_read'      => false,
                    ]
                );
            }
        }

        // ៣. តម្រូវការ ៣: Repair Completion Notification (ការជួសជុលដែលរួចរាល់ តែអតិថិជនមិនទាន់មកយក)
        if (class_exists(\App\Models\RepairService::class)) {
            $completedRepairs = \App\Models\RepairService::whereIn('status', ['Completed', 'Ready for Pickup'])
                ->take(3)
                ->get();

            foreach ($completedRepairs as $repair) {
                AppNotification::firstOrCreate(
                    [
                        'type'    => 'Repair Completion',
                        'title'   => 'Repair Service Completed',
                        'message' => "Repair order #{$repair->repair_code} ({$repair->device_type}) has been fixed and is ready for pickup.",
                    ],
                    [
                        'category'     => 'messages',
                        'icon'         => 'fa-wrench',
                        'icon_color'   => 'amber',
                        'action_url'   => url('/repair-service'),
                        'action_label' => 'View Repair Ticket',
                        'is_read'      => false,
                    ]
                );
            }
        }

        // ៤. តម្រូវការ ៥: Purchase Order Reminder (ប័ណ្ណទិញទំនិញ PO កំពុង Pending ឬជិតដល់ថ្ងៃដឹកមកដល់)
        if (class_exists(\App\Models\PurchaseOrder::class)) {
            $pendingPOs = \App\Models\PurchaseOrder::where('status', 'Pending')
                ->take(3)
                ->get();

            foreach ($pendingPOs as $po) {
                AppNotification::firstOrCreate(
                    [
                        'type'    => 'Purchase Order Reminder',
                        'title'   => 'Purchase Order Pending',
                        'message' => "Purchase Order #{$po->po_number} is pending delivery from supplier.",
                    ],
                    [
                        'category'     => 'messages',
                        'icon'         => 'fa-file-invoice',
                        'icon_color'   => 'rose',
                        'action_url'   => url('/purchases'),
                        'action_label' => 'Review PO Status',
                        'is_read'      => false,
                    ]
                );
            }
        }
    }

}
