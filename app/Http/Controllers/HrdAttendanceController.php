<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HrdEmployee;
use App\Models\HrdAttendance;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class HrdAttendanceController extends Controller
{
    /**
     * Display attendance records.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $employee = HrdEmployee::where('user_id', $user->id)->first();
        
        if (!$employee) {
            return redirect()->route('dashboard')->with('error', 'Employee profile not found.');
        }

        $attendance = HrdAttendance::where('employee_id', $employee->id)
            ->with('employee')
            ->orderBy('date', 'desc')
            ->paginate(20);

        return Inertia::render('hrd/attendance/index', [
            'attendance' => $attendance,
            'employee' => $employee,
        ]);
    }

    /**
     * Store a check-in record.
     */
    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'type' => 'required|in:check_in,check_out',
        ]);

        $user = $request->user();
        $employee = HrdEmployee::where('user_id', $user->id)->first();
        
        if (!$employee) {
            return redirect()->route('dashboard')->with('error', 'Employee profile not found.');
        }

        $today = Carbon::today();
        $now = Carbon::now();

        $attendance = HrdAttendance::firstOrCreate(
            [
                'employee_id' => $employee->id,
                'date' => $today,
            ],
            [
                'status' => 'present',
            ]
        );

        if ($request->type === 'check_in') {
            if ($attendance->check_in_time) {
                return redirect()->route('hrd.dashboard')
                    ->with('error', 'You have already checked in today.');
            }

            $attendance->update([
                'check_in_time' => $now,
                'latitude_in' => $request->latitude,
                'longitude_in' => $request->longitude,
                'status' => $now->format('H:i') > '09:00' ? 'late' : 'present',
            ]);

            return redirect()->route('hrd.dashboard')
                ->with('success', 'Successfully checked in at ' . $now->format('H:i'));
        }

        if ($request->type === 'check_out') {
            if (!$attendance->check_in_time) {
                return redirect()->route('hrd.dashboard')
                    ->with('error', 'You must check in first before checking out.');
            }

            if ($attendance->check_out_time) {
                return redirect()->route('hrd.dashboard')
                    ->with('error', 'You have already checked out today.');
            }

            $checkInTime = Carbon::parse($attendance->check_in_time);
            $workMinutes = $checkInTime->diffInMinutes($now);

            $attendance->update([
                'check_out_time' => $now,
                'latitude_out' => $request->latitude,
                'longitude_out' => $request->longitude,
                'work_hours' => $workMinutes,
            ]);

            $workHours = floor($workMinutes / 60);
            $workMins = $workMinutes % 60;

            return redirect()->route('hrd.dashboard')
                ->with('success', "Successfully checked out at {$now->format('H:i')}. Work time: {$workHours}h {$workMins}m");
        }

        return redirect()->route('hrd.dashboard');
    }
}