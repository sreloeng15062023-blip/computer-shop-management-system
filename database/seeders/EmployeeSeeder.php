<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\WorkSchedule;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        // 1. Ensure Roles
        $managerRole = Role::firstOrCreate(['role_name' => 'Manager'], ['description' => 'Store operations and staff management', 'status' => 'Active']);
        $salesRole   = Role::firstOrCreate(['role_name' => 'Sale Staff'], ['description' => 'Customer assistance and POS transactions', 'status' => 'Active']);
        $techRole    = Role::firstOrCreate(['role_name' => 'Technician'], ['description' => 'Hardware repair and troubleshooting', 'status' => 'Active']);
        $cashierRole = Role::firstOrCreate(['role_name' => 'Cashier'], ['description' => 'Counter cashier and receipt printing', 'status' => 'Active']);
        $storeRole   = Role::firstOrCreate(['role_name' => 'Storekeeper'], ['description' => 'Inventory, warehouse and procurement', 'status' => 'Active']);

        // 2. Employee records matching Mockup
        $employeesData = [
            [
                'employee_id' => 'EMP-001',
                'full_name'   => 'Sok Dara',
                'first_name'  => 'Dara',
                'last_name'   => 'Sok',
                'gender'      => 'Male',
                'date_of_birth' => '1998-05-12',
                'position'    => 'Store Manager',
                'role_id'     => $managerRole->id,
                'phone'       => '012 345 678',
                'email'       => 'dara@example.com',
                'address'     => 'Svay Dangkum, Siem Reap, Cambodia',
                'salary'      => 1500.00,
                'hire_date'   => '2024-01-15',
                'status'      => 'Active',
                'avatar'      => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            [
                'employee_id' => 'EMP-002',
                'full_name'   => 'Chhun Sopheak',
                'first_name'  => 'Sopheak',
                'last_name'   => 'Chhun',
                'gender'      => 'Female',
                'date_of_birth' => '2000-08-20',
                'position'    => 'Sales Staff',
                'role_id'     => $salesRole->id,
                'phone'       => '010 234 567',
                'email'       => 'sopheak@example.com',
                'address'     => 'Tuol Kouk, Phnom Penh',
                'salary'      => 800.00,
                'hire_date'   => '2024-03-01',
                'status'      => 'Active',
                'avatar'      => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            [
                'employee_id' => 'EMP-003',
                'full_name'   => 'Vann Rith',
                'first_name'  => 'Rith',
                'last_name'   => 'Vann',
                'gender'      => 'Male',
                'date_of_birth' => '1995-11-05',
                'position'    => 'Technician',
                'role_id'     => $techRole->id,
                'phone'       => '017 987 654',
                'email'       => 'rith@example.com',
                'address'     => 'Chamkar Mon, Phnom Penh',
                'salary'      => 950.00,
                'hire_date'   => '2024-02-10',
                'status'      => 'Active',
                'avatar'      => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            [
                'employee_id' => 'EMP-004',
                'full_name'   => 'Kim Sovan',
                'first_name'  => 'Sovan',
                'last_name'   => 'Kim',
                'gender'      => 'Male',
                'date_of_birth' => '1999-03-15',
                'position'    => 'Cashier',
                'role_id'     => $cashierRole->id,
                'phone'       => '096 123 456',
                'email'       => 'sovan@example.com',
                'address'     => 'Sen Sok, Phnom Penh',
                'salary'      => 750.00,
                'hire_date'   => '2024-04-05',
                'status'      => 'Active',
                'avatar'      => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            [
                'employee_id' => 'EMP-005',
                'full_name'   => 'Lay Meng',
                'first_name'  => 'Meng',
                'last_name'   => 'Lay',
                'gender'      => 'Male',
                'date_of_birth' => '1996-07-22',
                'position'    => 'Storekeeper',
                'role_id'     => $storeRole->id,
                'phone'       => '011 222 333',
                'email'       => 'meng@example.com',
                'address'     => 'Meanchey, Phnom Penh',
                'salary'      => 700.00,
                'hire_date'   => '2024-05-12',
                'status'      => 'On Leave',
                'avatar'      => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            [
                'employee_id' => 'EMP-006',
                'full_name'   => 'Chea Vutha',
                'first_name'  => 'Vutha',
                'last_name'   => 'Chea',
                'gender'      => 'Male',
                'date_of_birth' => '2001-01-30',
                'position'    => 'Sales Staff',
                'role_id'     => $salesRole->id,
                'phone'       => '093 444 555',
                'email'       => 'vutha@example.com',
                'address'     => 'Daun Penh, Phnom Penh',
                'salary'      => 800.00,
                'hire_date'   => '2024-06-20',
                'status'      => 'Active',
                'avatar'      => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            [
                'employee_id' => 'EMP-007',
                'full_name'   => 'Chan Mony',
                'first_name'  => 'Mony',
                'last_name'   => 'Chan',
                'gender'      => 'Female',
                'date_of_birth' => '1997-09-18',
                'position'    => 'Technician',
                'role_id'     => $techRole->id,
                'phone'       => '098 765 432',
                'email'       => 'mony@example.com',
                'address'     => 'Chbar Ampov, Phnom Penh',
                'salary'      => 900.00,
                'hire_date'   => '2024-07-01',
                'status'      => 'Inactive',
                'avatar'      => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            [
                'employee_id' => 'EMP-008',
                'full_name'   => 'Srey Meas',
                'first_name'  => 'Meas',
                'last_name'   => 'Srey',
                'gender'      => 'Female',
                'date_of_birth' => '2000-12-14',
                'position'    => 'Sales Staff',
                'role_id'     => $salesRole->id,
                'phone'       => '015 888 999',
                'email'       => 'meas@example.com',
                'address'     => 'BKK 1, Phnom Penh',
                'salary'      => 800.00,
                'hire_date'   => '2024-08-15',
                'status'      => 'Active',
                'avatar'      => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            [
                'employee_id' => 'EMP-009',
                'full_name'   => 'Heng Sovann',
                'first_name'  => 'Sovann',
                'last_name'   => 'Heng',
                'gender'      => 'Male',
                'date_of_birth' => '1994-06-10',
                'position'    => 'Technician',
                'role_id'     => $techRole->id,
                'phone'       => '077 111 222',
                'email'       => 'sovann.h@example.com',
                'address'     => 'Russey Keo, Phnom Penh',
                'salary'      => 1200.00,
                'hire_date'   => '2024-09-01',
                'status'      => 'Active',
                'avatar'      => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            [
                'employee_id' => 'EMP-010',
                'full_name'   => 'Nuon Piseth',
                'first_name'  => 'Piseth',
                'last_name'   => 'Nuon',
                'gender'      => 'Male',
                'date_of_birth' => '1999-10-25',
                'position'    => 'Cashier',
                'role_id'     => $cashierRole->id,
                'phone'       => '088 333 444',
                'email'       => 'piseth.n@example.com',
                'address'     => 'Por Senchey, Phnom Penh',
                'salary'      => 1100.00,
                'hire_date'   => '2024-09-10',
                'status'      => 'Active',
                'avatar'      => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            [
                'employee_id' => 'EMP-011',
                'full_name'   => 'San Darith',
                'first_name'  => 'Darith',
                'last_name'   => 'San',
                'gender'      => 'Male',
                'date_of_birth' => '1996-04-18',
                'position'    => 'Sales Staff',
                'role_id'     => $salesRole->id,
                'phone'       => '092 555 666',
                'email'       => 'darith.s@example.com',
                'address'     => 'Kandal Province',
                'salary'      => 1200.00,
                'hire_date'   => '2024-09-15',
                'status'      => 'Active',
                'avatar'      => 'https://images.unsplash.com/photo-1527980965255-d3b416303d12?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            [
                'employee_id' => 'EMP-012',
                'full_name'   => 'Sok Theara',
                'first_name'  => 'Theara',
                'last_name'   => 'Sok',
                'gender'      => 'Male',
                'date_of_birth' => '1995-02-28',
                'position'    => 'Storekeeper',
                'role_id'     => $storeRole->id,
                'phone'       => '086 777 888',
                'email'       => 'theara.s@example.com',
                'address'     => 'Siem Reap, Cambodia',
                'salary'      => 1100.00,
                'hire_date'   => '2024-09-20',
                'status'      => 'Active',
                'avatar'      => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=120&h=120&q=80',
            ],
        ];

        foreach ($employeesData as $empData) {
            // Find or create User login account
            $user = User::firstOrCreate(
                ['email' => $empData['email']],
                [
                    'name'     => $empData['full_name'],
                    'password' => Hash::make('password123'),
                    'role_id'  => $empData['role_id'],
                ]
            );

            $empData['user_id'] = $user->id;

            $employee = Employee::updateOrCreate(
                ['employee_id' => $empData['employee_id']],
                $empData
            );

            // Add Work Schedule
            WorkSchedule::updateOrCreate(
                ['employee_id' => $employee->id],
                [
                    'shift_name'     => 'Full Day (ពេញម៉ោង)',
                    'start_time'     => '08:00:00',
                    'end_time'       => '17:00:00',
                    'work_days'      => 'Monday - Saturday',
                    'effective_date' => Carbon::parse($empData['hire_date']),
                    'status'         => 'Active',
                ]
            );

            // Add Attendance record for today
            Attendance::updateOrCreate(
                ['employee_id' => $employee->id, 'date' => today()],
                [
                    'check_in'      => '07:55:00',
                    'check_out'     => '17:05:00',
                    'working_hours' => 8.0,
                    'status'        => $empData['status'] === 'On Leave' ? 'On Leave' : 'Present',
                    'notes'         => 'Biometric fingerprint logged',
                ]
            );
        }
    }
}
