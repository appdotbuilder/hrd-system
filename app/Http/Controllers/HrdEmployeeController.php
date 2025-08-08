<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HrdEmployee;
use App\Models\HrdDepartment;
use App\Models\HrdPosition;
use App\Models\HrdRole;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HrdEmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index(Request $request)
    {
        $query = HrdEmployee::with(['user', 'department', 'position', 'role']);

        // Filter by department
        if ($request->department) {
            $query->where('department_id', $request->department);
        }

        // Filter by status
        if ($request->status) {
            $query->where('employment_status', $request->status);
        }

        // Search by name or employee ID
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        $employees = $query->latest()->paginate(15);
        $departments = HrdDepartment::active()->get(['id', 'name']);

        return Inertia::render('hrd/employees/index', [
            'employees' => $employees,
            'departments' => $departments,
            'filters' => $request->only(['department', 'status', 'search']),
        ]);
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        $departments = HrdDepartment::active()->get(['id', 'name']);
        $positions = HrdPosition::with('department')->where('is_active', true)->get();
        $roles = HrdRole::all(['id', 'name', 'display_name']);

        return Inertia::render('hrd/employees/create', [
            'departments' => $departments,
            'positions' => $positions,
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'employee_id' => 'required|string|max:20|unique:hrd_employees,employee_id',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'department_id' => 'nullable|exists:hrd_departments,id',
            'position_id' => 'nullable|exists:hrd_positions,id',
            'role_id' => 'required|exists:hrd_roles,id',
            'hire_date' => 'required|date',
            'salary' => 'nullable|numeric|min:0',
        ]);

        // Create user account
        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => bcrypt('password123'), // Default password
            'email_verified_at' => now(),
        ]);

        // Create employee record
        HrdEmployee::create(array_merge($validated, [
            'user_id' => $user->id,
            'employment_status' => 'active',
        ]));

        return redirect()->route('hrd.employees.index')
            ->with('success', 'Employee created successfully. Default password: password123');
    }

    /**
     * Display the specified employee.
     */
    public function show(HrdEmployee $employee)
    {
        $employee->load(['user', 'department', 'position', 'role', 'attendance' => function ($query) {
            $query->latest()->take(10);
        }]);

        return Inertia::render('hrd/employees/show', [
            'employee' => $employee,
        ]);
    }

    /**
     * Show the form for editing the employee.
     */
    public function edit(HrdEmployee $employee)
    {
        $employee->load('user');
        $departments = HrdDepartment::active()->get(['id', 'name']);
        $positions = HrdPosition::with('department')->where('is_active', true)->get();
        $roles = HrdRole::all(['id', 'name', 'display_name']);

        return Inertia::render('hrd/employees/edit', [
            'employee' => $employee,
            'departments' => $departments,
            'positions' => $positions,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified employee.
     */
    public function update(Request $request, HrdEmployee $employee)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'employee_id' => 'required|string|max:20|unique:hrd_employees,employee_id,' . $employee->id,
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'department_id' => 'nullable|exists:hrd_departments,id',
            'position_id' => 'nullable|exists:hrd_positions,id',
            'role_id' => 'required|exists:hrd_roles,id',
            'hire_date' => 'required|date',
            'salary' => 'nullable|numeric|min:0',
            'employment_status' => 'required|in:active,inactive,terminated,suspended',
        ]);

        $employee->update($validated);

        // Update user name
        $employee->user->update([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
        ]);

        return redirect()->route('hrd.employees.show', $employee)
            ->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified employee.
     */
    public function destroy(HrdEmployee $employee)
    {
        $employee->update(['employment_status' => 'terminated']);
        
        return redirect()->route('hrd.employees.index')
            ->with('success', 'Employee terminated successfully.');
    }
}