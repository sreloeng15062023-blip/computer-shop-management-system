<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    /**
     * FUNCTION 1: index() - បង្ហាញផ្ទាំង Settings និងទាញយកទិន្នន័យទាំងអស់មកចាក់លើ UI
     */
    public function index()
    {
        // ទាញទិន្នន័យ Setting ទាំងអស់ចេញជា Array Key => Value
        $settings = Setting::pluck('value', 'key')->toArray();

        // ពិនិត្យមើលបញ្ជី File Backup
        $backupDir = storage_path('app/backups');
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        $backups = [];
        foreach (File::files($backupDir) as $file) {
            $backups[] = [
                'name' => $file->getFilename(),
                'size' => round($file->getSize() / 1024, 2) . ' KB',
                'date' => date('Y-m-d h:i A', $file->getMTime()),
            ];
        }

        // បញ្ជូនទិន្នន័យទៅកាន់ឯកសារ resources/views/settings.blade.php
        return view('settings', compact('settings', 'backups'));
    }

    /**
     * FUNCTION 2: updateGeneral() - រក្សាទុកទិន្នន័យពីផ្ទាំង General Settings តាម AJAX
     */
    public function updateGeneral(Request $request)
    {
        $keys = [
            'system_name', 'shop_name', 'language', 'timezone',
            'default_currency', 'tax_rate', 'items_per_page', 'system_description',
            'feature_pos', 'feature_purchase', 'feature_repair', 'feature_inventory',
            'feature_warranty', 'feature_notification', 'feature_multibranch', 'feature_advreport'
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key), 'general');
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'General settings saved successfully!'
        ]);
    }

    /**
     * FUNCTION 3: updateShop() - រក្សាទុកទិន្នន័យ Shop Information
     */
    public function updateShop(Request $request)
    {
        $fields = ['shop_name', 'shop_phone', 'shop_email', 'shop_website', 'shop_address'];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                Setting::set($field, $request->input($field), 'shop');
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Shop information updated successfully!'
        ]);
    }

    /**
     * FUNCTION 4: createBackup() - បង្កើត Database Backup (.sql) តាមតម្រូវការ Assignment
     */
    public function createBackup(Request $request)
    {
        $backupDir = storage_path('app/backups');
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        $fileName = 'backup_' . date('Y_m_d_His') . '.sql';
        $filePath = $backupDir . '/' . $fileName;

        $tables = DB::select('SHOW TABLES');
        $dbKey = 'Tables_in_' . env('DB_DATABASE');

        $dump = "-- TECHZONE Database Backup\n-- Date: " . now() . "\n\n";

        foreach ($tables as $table) {
            $tableName = $table->$dbKey;
            $create = DB::select("SHOW CREATE TABLE `{$tableName}`");
            $dump .= "\n\n" . $create[0]->{'Create Table'} . ";\n\n";

            $rows = DB::table($tableName)->get();
            foreach ($rows as $row) {
                $values = array_map(function ($val) {
                    return is_null($val) ? 'NULL' : "'" . addslashes($val) . "'";
                }, (array) $row);
                $dump .= "INSERT INTO `{$tableName}` VALUES (" . implode(', ', $values) . ");\n";
            }
        }

        File::put($filePath, $dump);

        return response()->json([
            'success' => true,
            'message' => 'Database backup created successfully!'
        ]);
    }
}
