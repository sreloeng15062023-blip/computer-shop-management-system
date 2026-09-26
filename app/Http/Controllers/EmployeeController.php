<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\WorkSchedule;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    /**
     * Display Employee Management (Feature #13)
     */
    public function index(Request $request)
    {
        // 1. Query Employees with filters
        $query = Employee::with(['role', 'user', 'schedules']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role_id') && $request->role_id !== 'all') {
            $query->where('role_id', $request->role_id);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $employees = $query->orderBy('id', 'asc')->paginate(10)->withQueryString();

        // 2. Calculate 5 Stat Cards matching Mockup
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('status', 'Active')->count();
        $onLeaveEmployees = Employee::where('status', 'On Leave')->count();
        $inactiveEmployees = Employee::where('status', 'Inactive')->count();
        $totalMonthlySalary = Employee::where('status', 'Active')->sum('salary');

        // 3. Roles and Schedules
        $roles = Role::where('status', 'Active')->orderBy('role_name', 'asc')->get();
        $featuredEmployee = Employee::with(['role', 'user', 'attendances', 'schedules'])->first();

        // 4. Shift calendar & attendance today
        $todayAttendances = Attendance::with('employee')
            ->whereDate('date', today())
            ->get();

        return view('employees', compact(
            'employees',
            'totalEmployees',
            'activeEmployees',
            'onLeaveEmployees',
            'inactiveEmployees',
            'totalMonthlySalary',
            'roles',
            'featuredEmployee',
            'todayAttendances'
        ));
    }

    /**
     * Store new employee (Step 6.1 & 6.2)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'     => 'required|string|max:255',
            'first_name'    => 'nullable|string|max:100',
            'last_name'     => 'nullable|string|max:100',
            'gender'        => 'required|in:Male,Female,Other',
            'date_of_birth' => 'nullable|date',
            'phone'         => 'required|string|max:50',
            'email'         => 'required|email|unique:employees,email',
            'address'       => 'nullable|string|max:500',
            'position'      => 'required|string|max:100',
            'role_id'       => 'nullable|exists:roles,id',
            'salary'        => 'nullable|numeric|min:0',
            'hire_date'     => 'required|date',
            'status'        => 'required|in:Active,On Leave,Inactive,Terminated',
            'password'      => 'nullable|string|min:6',
        ]);

        DB::beginTransaction();
        try {
            // Auto generate EMP-XXX
            $nextId = (Employee::max('id') ?? 0) + 1;
            $empCode = 'EMP-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

            // Create login user account if requested or default
            $userId = null;
            if (!empty($validated['password']) || !User::where('email', $validated['email'])->exists()) {
                $user = User::create([
                    'name'     => $validated['full_name'],
                    'email'    => $validated['email'],
                    'password' => Hash::make($validated['password'] ?? 'password123'),
                    'role_id'  => $validated['role_id'] ?? null,
                ]);
                $userId = $user->id;
            }

            // Create employee
            $employee = Employee::create([
                'employee_id'   => $empCode,
                'user_id'       => $userId,
                'role_id'       => $validated['role_id'] ?? null,
                'first_name'    => $validated['first_name'] ?? '',
                'last_name'     => $validated['last_name'] ?? '',
                'full_name'     => $validated['full_name'],
                'gender'        => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'phone'         => $validated['phone'],
                'email'         => $validated['email'],
                'address'       => $validated['address'] ?? 'Phnom Penh, Cambodia',
                'position'      => $validated['position'],
                'salary'        => $validated['salary'] ?? 500.00,
                'hire_date'     => $validated['hire_date'],
                'status'        => $validated['status'],
                'avatar'        => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=120&h=120&q=80',
            ]);

            // Assign default work schedule
            WorkSchedule::create([
                'employee_id'    => $employee->id,
                'shift_name'     => 'Full Day (ពេញម៉ោង)',
                'start_time'     => '08:00:00',
                'end_time'       => '17:00:00',
                'work_days'      => 'Monday - Saturday',
                'effective_date' => now(),
                'status'         => 'Active'
            ]);

            DB::commit();

            return redirect()->route('employees')->with('success', "បុគ្គលិក {$employee->full_name} ({$empCode}) ត្រូវបានចុះឈ្មោះដោយជោគជ័យ!");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'បរាជ័យក្នុងការចុះឈ្មោះ: ' . $e->getMessage());
        }
    }

    /**
     * Update employee
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'full_name'     => 'required|string|max:255',
            'first_name'    => 'nullable|string|max:100',
            'last_name'     => 'nullable|string|max:100',
            'gender'        => 'required|in:Male,Female,Other',
            'date_of_birth' => 'nullable|date',
            'phone'         => 'required|string|max:50',
            'email'         => "required|email|unique:employees,email,{$id}",
            'address'       => 'nullable|string|max:500',
            'position'      => 'required|string|max:100',
            'role_id'       => 'nullable|exists:roles,id',
            'salary'        => 'nullable|numeric|min:0',
            'status'        => 'required|in:Active,On Leave,Inactive,Terminated',
        ]);

        $employee->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'ព័ត៌មានបុគ្គលិកត្រូវបានកែប្រែដោយជោគជ័យ', 'employee' => $employee]);
        }

        return redirect()->route('employees')->with('success', 'ព័ត៌មានបុគ្គលិកត្រូវបានកែប្រែរួចរាល់!');
    }

    /**
     * Record attendance (Step 6.2)
     */
    public function recordAttendance(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $today = today();

        $attendance = Attendance::firstOrCreate(
            ['employee_id' => $employee->id, 'date' => $today],
            ['check_in' => now()->format('H:i:s'), 'status' => 'Present']
        );

        if ($attendance->wasRecentlyCreated) {
            $msg = "បានកត់ត្រាវត្តមាន Check In ម៉ោង " . now()->format('h:i A');
        } else {
            $attendance->check_out = now()->format('H:i:s');
            $start = Carbon::parse($attendance->check_in);
            $end = Carbon::parse($attendance->check_out);
            $attendance->working_hours = round($end->diffInMinutes($start) / 60, 2);
            $attendance->save();
            $msg = "បានកត់ត្រាវត្តមាន Check Out ម៉ោង " . now()->format('h:i A');
        }

        return response()->json(['success' => true, 'message' => $msg, 'attendance' => $attendance]);
    }

    /**
     * Show employee details JSON
     */
    public function show($id)
    {
        $employee = Employee::with(['role', 'user', 'attendances', 'schedules'])->findOrFail($id);
        return response()->json(['success' => true, 'employee' => $employee]);
    }

    /**
     * Remove employee
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->status = 'Inactive';
        $employee->save();

        return redirect()->route('employees')->with('success', 'បុគ្គលិកត្រូវបានប្តូរស្ថានភាពទៅ Inactive');
    }
}
