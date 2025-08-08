<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HrdEmployee;
use App\Models\HrdAttendance;
use App\Models\HrdLeaveRequest;
use App\Models\HrdDepartment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class HrdDashboardController extends Controller
{
    /**
     * Display the HRD dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $employee = HrdEmployee::where('user_id', $user->id)->with(['role', 'department', 'position'])->first();
        
        // Get today's stats
        $today = Carbon::today();
        $currentMonth = Carbon::now()->format('Y-m');
        
        $stats = [
            'total_employees' => HrdEmployee::active()->count(),
            'present_today' => HrdAttendance::whereDate('date', $today)
                ->where('status', 'present')
                ->count(),
            'departments_count' => HrdDepartment::active()->count(),
            'pending_leaves' => HrdLeaveRequest::where('status', 'pending')->count(),
        ];

        // Get recent activities
        $recentActivities = collect([]);
        
        // Recent attendance
        $recentAttendance = HrdAttendance::with('employee')
            ->whereDate('date', $today)
            ->whereNotNull('check_in_time')
            ->latest('check_in_time')
            ->take(5)
            ->get()
            ->map(function ($attendance) {
                return [
                    'type' => 'attendance',
                    'title' => $attendance->employee->full_name . ' checked in',
                    'time' => $attendance->check_in_time->format('H:i'),
                    'status' => $attendance->status,
                ];
            });

        // Recent leave requests
        $recentLeaves = HrdLeaveRequest::with(['employee', 'leaveType'])
            ->where('status', 'pending')
            ->latest('created_at')
            ->take(3)
            ->get()
            ->map(function ($leave) {
                return [
                    'type' => 'leave',
                    'title' => $leave->employee->full_name . ' requested ' . $leave->leaveType->name,
                    'time' => $leave->created_at->format('H:i'),
                    'status' => $leave->status,
                ];
            });

        $recentActivities = $recentActivities->concat($recentAttendance)->concat($recentLeaves)
            ->sortByDesc('time')
            ->take(10)
            ->values();

        // Check if user can check in today
        $todayAttendance = null;
        if ($employee) {
            $todayAttendance = HrdAttendance::where('employee_id', $employee->id)
                ->whereDate('date', $today)
                ->first();
        }

        return Inertia::render('hrd/dashboard', [
            'employee' => $employee,
            'stats' => $stats,
            'recentActivities' => $recentActivities,
            'todayAttendance' => $todayAttendance,
            'canCheckIn' => $employee && (!$todayAttendance || !$todayAttendance->check_in_time),
            'canCheckOut' => $employee && $todayAttendance && $todayAttendance->check_in_time && !$todayAttendance->check_out_time,
        ]);
    }
}