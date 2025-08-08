<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HrdRole;
use App\Models\HrdDepartment;
use App\Models\HrdPosition;
use App\Models\HrdLeaveType;
use App\Models\HrdWorkSchedule;
use App\Models\User;
use App\Models\HrdEmployee;
use Carbon\Carbon;

class HrdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Full system access',
                'permissions' => ['*'],
            ],
            [
                'name' => 'hr',
                'display_name' => 'HR Manager',
                'description' => 'Human Resources management',
                'permissions' => ['employees.manage', 'attendance.view', 'leaves.manage', 'payroll.manage'],
            ],
            [
                'name' => 'manager',
                'display_name' => 'Department Manager',
                'description' => 'Department management',
                'permissions' => ['employees.view', 'attendance.view', 'leaves.approve'],
            ],
            [
                'name' => 'employee',
                'display_name' => 'Employee',
                'description' => 'Basic employee access',
                'permissions' => ['attendance.own', 'leaves.request', 'profile.manage'],
            ],
        ];

        foreach ($roles as $role) {
            HrdRole::create($role);
        }

        // Create departments
        $departments = [
            ['name' => 'Human Resources', 'code' => 'HR', 'description' => 'Human Resources Department'],
            ['name' => 'Information Technology', 'code' => 'IT', 'description' => 'IT Department'],
            ['name' => 'Finance', 'code' => 'FIN', 'description' => 'Finance Department'],
            ['name' => 'Marketing', 'code' => 'MKT', 'description' => 'Marketing Department'],
            ['name' => 'Operations', 'code' => 'OPS', 'description' => 'Operations Department'],
        ];

        foreach ($departments as $dept) {
            HrdDepartment::create($dept);
        }

        // Create positions
        $positions = [
            ['title' => 'HR Manager', 'code' => 'HRM', 'department_id' => 1, 'min_salary' => 80000, 'max_salary' => 120000],
            ['title' => 'HR Specialist', 'code' => 'HRS', 'department_id' => 1, 'min_salary' => 50000, 'max_salary' => 70000],
            ['title' => 'IT Manager', 'code' => 'ITM', 'department_id' => 2, 'min_salary' => 90000, 'max_salary' => 150000],
            ['title' => 'Software Developer', 'code' => 'DEV', 'department_id' => 2, 'min_salary' => 60000, 'max_salary' => 100000],
            ['title' => 'Finance Manager', 'code' => 'FIM', 'department_id' => 3, 'min_salary' => 85000, 'max_salary' => 130000],
            ['title' => 'Accountant', 'code' => 'ACC', 'department_id' => 3, 'min_salary' => 45000, 'max_salary' => 65000],
            ['title' => 'Marketing Manager', 'code' => 'MKM', 'department_id' => 4, 'min_salary' => 75000, 'max_salary' => 110000],
            ['title' => 'Marketing Specialist', 'code' => 'MKS', 'department_id' => 4, 'min_salary' => 40000, 'max_salary' => 60000],
        ];

        foreach ($positions as $position) {
            HrdPosition::create($position);
        }

        // Create leave types
        $leaveTypes = [
            ['name' => 'Annual Leave', 'code' => 'AL', 'max_days_per_year' => 21, 'is_paid' => true],
            ['name' => 'Sick Leave', 'code' => 'SL', 'max_days_per_year' => 10, 'is_paid' => true],
            ['name' => 'Maternity Leave', 'code' => 'ML', 'max_days_per_year' => 90, 'is_paid' => true],
            ['name' => 'Paternity Leave', 'code' => 'PL', 'max_days_per_year' => 7, 'is_paid' => true],
            ['name' => 'Emergency Leave', 'code' => 'EL', 'max_days_per_year' => 3, 'is_paid' => true],
            ['name' => 'Unpaid Leave', 'code' => 'UL', 'max_days_per_year' => null, 'is_paid' => false],
        ];

        foreach ($leaveTypes as $leaveType) {
            HrdLeaveType::create($leaveType);
        }

        // Create work schedules
        $schedules = [
            [
                'name' => 'Regular Schedule',
                'start_time' => '09:00',
                'end_time' => '17:00',
                'break_duration' => 60,
                'work_days' => [1, 2, 3, 4, 5], // Monday to Friday
            ],
            [
                'name' => 'Flexible Schedule',
                'start_time' => '08:00',
                'end_time' => '16:00',
                'break_duration' => 60,
                'work_days' => [1, 2, 3, 4, 5],
                'is_flexible' => true,
                'flex_start_range' => 120, // 2 hours flexibility
                'flex_end_range' => 120,
            ],
        ];

        foreach ($schedules as $schedule) {
            HrdWorkSchedule::create($schedule);
        }

        // Create admin user and employee
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@hrd.test',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        HrdEmployee::create([
            'user_id' => $adminUser->id,
            'employee_id' => 'EMP001',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'department_id' => 1,
            'position_id' => 1,
            'role_id' => 1, // Admin role
            'hire_date' => Carbon::now()->subYears(2),
            'employment_status' => 'active',
            'salary' => 100000,
        ]);

        // Create HR manager
        $hrUser = User::create([
            'name' => 'Sarah Johnson',
            'email' => 'hr@hrd.test',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        HrdEmployee::create([
            'user_id' => $hrUser->id,
            'employee_id' => 'EMP002',
            'first_name' => 'Sarah',
            'last_name' => 'Johnson',
            'phone' => '+1234567890',
            'birth_date' => '1985-03-15',
            'gender' => 'female',
            'department_id' => 1,
            'position_id' => 1,
            'role_id' => 2, // HR role
            'hire_date' => Carbon::now()->subYear(),
            'employment_status' => 'active',
            'salary' => 95000,
        ]);

        // Create some sample employees
        $sampleEmployees = [
            [
                'name' => 'John Smith',
                'email' => 'john@hrd.test',
                'first_name' => 'John',
                'last_name' => 'Smith',
                'employee_id' => 'EMP003',
                'department_id' => 2,
                'position_id' => 4,
                'role_id' => 4,
                'salary' => 75000,
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily@hrd.test',
                'first_name' => 'Emily',
                'last_name' => 'Davis',
                'employee_id' => 'EMP004',
                'department_id' => 4,
                'position_id' => 8,
                'role_id' => 4,
                'salary' => 55000,
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael@hrd.test',
                'first_name' => 'Michael',
                'last_name' => 'Brown',
                'employee_id' => 'EMP005',
                'department_id' => 3,
                'position_id' => 6,
                'role_id' => 4,
                'salary' => 58000,
            ],
        ];

        foreach ($sampleEmployees as $emp) {
            $user = User::create([
                'name' => $emp['name'],
                'email' => $emp['email'],
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);

            HrdEmployee::create([
                'user_id' => $user->id,
                'employee_id' => $emp['employee_id'],
                'first_name' => $emp['first_name'],
                'last_name' => $emp['last_name'],
                'department_id' => $emp['department_id'],
                'position_id' => $emp['position_id'],
                'role_id' => $emp['role_id'],
                'hire_date' => Carbon::now()->subMonths(random_int(3, 18)),
                'employment_status' => 'active',
                'salary' => $emp['salary'],
            ]);
        }
    }
}