import React from 'react';
import { Head, router } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';

import { Button } from '@/components/ui/button';

interface Employee {
    id: number;
    employee_id: string;
    first_name: string;
    last_name: string;
    full_name: string;
    department?: {
        id: number;
        name: string;
        code: string;
    };
    position?: {
        id: number;
        title: string;
    };
    role: {
        id: number;
        name: string;
        display_name: string;
    };
}

interface Attendance {
    id: number;
    date: string;
    check_in_time?: string;
    check_out_time?: string;
    status: string;
}

interface Stats {
    total_employees: number;
    present_today: number;
    departments_count: number;
    pending_leaves: number;
}

interface Activity {
    type: string;
    title: string;
    time: string;
    status: string;
}

interface Props {
    employee: Employee;
    stats: Stats;
    recentActivities: Activity[];
    todayAttendance?: Attendance;
    canCheckIn: boolean;
    canCheckOut: boolean;
    [key: string]: unknown;
}

export default function HrdDashboard({ 
    employee, 
    stats, 
    recentActivities, 
    todayAttendance, 
    canCheckIn, 
    canCheckOut 
}: Props) {
    const [location, setLocation] = React.useState<{ latitude: number; longitude: number } | null>(null);
    const [loading, setLoading] = React.useState(false);

    const getCurrentLocation = () => {
        return new Promise<{ latitude: number; longitude: number }>((resolve, reject) => {
            if (!navigator.geolocation) {
                reject(new Error('Geolocation is not supported'));
                return;
            }

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    resolve({
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                    });
                },
                (error) => {
                    reject(error);
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 }
            );
        });
    };

    const handleAttendanceAction = async (type: 'check_in' | 'check_out') => {
        setLoading(true);
        try {
            const location = await getCurrentLocation();
            setLocation(location);
            
            router.post(route('hrd.attendance.store'), {
                type,
                latitude: location.latitude,
                longitude: location.longitude,
            }, {
                preserveState: true,
                preserveScroll: true,
                onFinish: () => setLoading(false),
            });
        } catch {
            alert('Unable to get your location. Please enable location services.');
            setLoading(false);
        }
    };

    const formatTime = (timeString?: string) => {
        if (!timeString) return '--:--';
        return new Date(timeString).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    };

    const getStatusColor = (status: string) => {
        switch (status) {
            case 'present': return 'text-green-600 bg-green-50';
            case 'late': return 'text-orange-600 bg-orange-50';
            case 'absent': return 'text-red-600 bg-red-50';
            case 'pending': return 'text-yellow-600 bg-yellow-50';
            default: return 'text-gray-600 bg-gray-50';
        }
    };

    return (
        <AppShell>
            <Head title="HRD Dashboard" />
            
            <div className="space-y-6">
                {/* Welcome Section */}
                <div className="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg p-6 text-white">
                    <div className="flex items-center justify-between">
                        <div>
                            <h1 className="text-2xl font-bold mb-2">
                                👋 Welcome back, {employee.first_name}!
                            </h1>
                            <p className="text-blue-100">
                                {employee.role.display_name} • {employee.department?.name} • {employee.position?.title}
                            </p>
                            <p className="text-sm text-blue-200 mt-1">
                                Employee ID: {employee.employee_id}
                            </p>
                        </div>
                        <div className="text-right">
                            <div className="text-sm text-blue-200">Today</div>
                            <div className="text-xl font-semibold">
                                {new Date().toLocaleDateString('en-US', {
                                    weekday: 'long',
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric'
                                })}
                            </div>
                        </div>
                    </div>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div className="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Total Employees</p>
                                <p className="text-2xl font-bold text-gray-900">{stats.total_employees}</p>
                            </div>
                            <div className="text-3xl">👥</div>
                        </div>
                    </div>

                    <div className="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Present Today</p>
                                <p className="text-2xl font-bold text-green-600">{stats.present_today}</p>
                            </div>
                            <div className="text-3xl">✅</div>
                        </div>
                    </div>

                    <div className="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Departments</p>
                                <p className="text-2xl font-bold text-blue-600">{stats.departments_count}</p>
                            </div>
                            <div className="text-3xl">🏢</div>
                        </div>
                    </div>

                    <div className="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Pending Leaves</p>
                                <p className="text-2xl font-bold text-orange-600">{stats.pending_leaves}</p>
                            </div>
                            <div className="text-3xl">📅</div>
                        </div>
                    </div>
                </div>

                {/* Attendance Section */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {/* Today's Attendance */}
                    <div className="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <h2 className="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            📍 Today's Attendance
                        </h2>
                        
                        {todayAttendance ? (
                            <div className="space-y-4">
                                <div className="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p className="text-sm text-gray-600">Check In</p>
                                        <p className="font-medium">{formatTime(todayAttendance.check_in_time)}</p>
                                    </div>
                                    <div>
                                        <p className="text-sm text-gray-600">Check Out</p>
                                        <p className="font-medium">{formatTime(todayAttendance.check_out_time)}</p>
                                    </div>
                                    <div>
                                        <span className={`px-2 py-1 rounded-full text-xs font-medium capitalize ${getStatusColor(todayAttendance.status)}`}>
                                            {todayAttendance.status}
                                        </span>
                                    </div>
                                </div>

                                <div className="flex gap-3">
                                    {canCheckIn && (
                                        <Button
                                            onClick={() => handleAttendanceAction('check_in')}
                                            disabled={loading}
                                            className="flex-1 bg-green-600 hover:bg-green-700"
                                        >
                                            {loading ? '📍 Getting Location...' : '✅ Check In'}
                                        </Button>
                                    )}
                                    {canCheckOut && (
                                        <Button
                                            onClick={() => handleAttendanceAction('check_out')}
                                            disabled={loading}
                                            className="flex-1 bg-red-600 hover:bg-red-700"
                                        >
                                            {loading ? '📍 Getting Location...' : '🚪 Check Out'}
                                        </Button>
                                    )}
                                </div>
                            </div>
                        ) : (
                            <div className="text-center py-8">
                                <div className="text-4xl mb-4">⏰</div>
                                <p className="text-gray-600 mb-4">No attendance record for today</p>
                                {canCheckIn && (
                                    <Button
                                        onClick={() => handleAttendanceAction('check_in')}
                                        disabled={loading}
                                        className="bg-green-600 hover:bg-green-700"
                                    >
                                        {loading ? '📍 Getting Location...' : '✅ Check In Now'}
                                    </Button>
                                )}
                            </div>
                        )}

                        {location && (
                            <div className="mt-4 p-3 bg-blue-50 rounded-lg">
                                <p className="text-sm text-blue-800">
                                    📍 Location: {location.latitude.toFixed(6)}, {location.longitude.toFixed(6)}
                                </p>
                            </div>
                        )}
                    </div>

                    {/* Recent Activities */}
                    <div className="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <h2 className="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            📊 Recent Activities
                        </h2>
                        
                        <div className="space-y-3">
                            {recentActivities.length > 0 ? (
                                recentActivities.map((activity, index) => (
                                    <div key={index} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div className="flex items-center space-x-3">
                                            <div className="text-lg">
                                                {activity.type === 'attendance' ? '✅' : '📅'}
                                            </div>
                                            <div>
                                                <p className="text-sm font-medium text-gray-900">{activity.title}</p>
                                                <p className="text-xs text-gray-500">{activity.time}</p>
                                            </div>
                                        </div>
                                        <span className={`px-2 py-1 rounded-full text-xs font-medium capitalize ${getStatusColor(activity.status)}`}>
                                            {activity.status}
                                        </span>
                                    </div>
                                ))
                            ) : (
                                <div className="text-center py-8">
                                    <div className="text-4xl mb-2">🔄</div>
                                    <p className="text-gray-600">No recent activities</p>
                                </div>
                            )}
                        </div>
                    </div>
                </div>

                {/* Quick Actions */}
                <div className="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <h2 className="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        ⚡ Quick Actions
                    </h2>
                    
                    <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <Button
                            variant="outline"
                            onClick={() => router.visit(route('hrd.attendance.index'))}
                            className="h-20 flex flex-col items-center justify-center space-y-2"
                        >
                            <div className="text-2xl">📊</div>
                            <span className="text-sm">View Attendance</span>
                        </Button>

                        {employee.role.name !== 'employee' && (
                            <Button
                                variant="outline"
                                onClick={() => router.visit(route('hrd.employees.index'))}
                                className="h-20 flex flex-col items-center justify-center space-y-2"
                            >
                                <div className="text-2xl">👥</div>
                                <span className="text-sm">Manage Employees</span>
                            </Button>
                        )}

                        <Button
                            variant="outline"
                            onClick={() => router.visit(route('profile.edit'))}
                            className="h-20 flex flex-col items-center justify-center space-y-2"
                        >
                            <div className="text-2xl">👤</div>
                            <span className="text-sm">My Profile</span>
                        </Button>

                        <Button
                            variant="outline"
                            className="h-20 flex flex-col items-center justify-center space-y-2"
                        >
                            <div className="text-2xl">📋</div>
                            <span className="text-sm">Request Leave</span>
                        </Button>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}