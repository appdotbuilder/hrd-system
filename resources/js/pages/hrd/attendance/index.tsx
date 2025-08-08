import React from 'react';
import { Head } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import Heading from '@/components/heading';

interface Employee {
    id: number;
    employee_id: string;
    first_name: string;
    last_name: string;
    full_name: string;
}

interface Attendance {
    id: number;
    date: string;
    check_in_time?: string;
    check_out_time?: string;
    work_hours?: number;
    status: string;
    latitude_in?: number;
    longitude_in?: number;
    latitude_out?: number;
    longitude_out?: number;
}

interface AttendanceData {
    data: Attendance[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

interface Props {
    attendance: AttendanceData;
    employee: Employee;
    [key: string]: unknown;
}

export default function AttendanceIndex({ attendance, employee }: Props) {
    const formatTime = (timeString?: string) => {
        if (!timeString) return '--:--';
        return new Date(timeString).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    };

    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleDateString('en-US', {
            weekday: 'short',
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    };

    const formatWorkHours = (minutes?: number) => {
        if (!minutes) return '--h --m';
        const hours = Math.floor(minutes / 60);
        const mins = minutes % 60;
        return `${hours}h ${mins}m`;
    };

    const getStatusColor = (status: string) => {
        switch (status) {
            case 'present': return 'text-green-600 bg-green-50 border-green-200';
            case 'late': return 'text-orange-600 bg-orange-50 border-orange-200';
            case 'absent': return 'text-red-600 bg-red-50 border-red-200';
            case 'partial': return 'text-yellow-600 bg-yellow-50 border-yellow-200';
            case 'holiday': return 'text-blue-600 bg-blue-50 border-blue-200';
            default: return 'text-gray-600 bg-gray-50 border-gray-200';
        }
    };

    const getStatusIcon = (status: string) => {
        switch (status) {
            case 'present': return '✅';
            case 'late': return '⏰';
            case 'absent': return '❌';
            case 'partial': return '⚠️';
            case 'holiday': return '🎉';
            default: return '❓';
        }
    };

    return (
        <AppShell>
            <Head title="My Attendance Record" />
            
            <div className="space-y-6">
                <Heading title="📊 My Attendance Record" />

                {/* Employee Info */}
                <div className="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <div className="flex items-center justify-between">
                        <div>
                            <h2 className="text-xl font-semibold text-gray-900">{employee.full_name}</h2>
                            <p className="text-gray-600">Employee ID: {employee.employee_id}</p>
                        </div>
                        <div className="text-right">
                            <p className="text-sm text-gray-600">Total Records</p>
                            <p className="text-2xl font-bold text-blue-600">{attendance.total}</p>
                        </div>
                    </div>
                </div>

                {/* Attendance Stats */}
                <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div className="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-green-600">Present Days</p>
                                <p className="text-xl font-bold text-green-700">
                                    {attendance.data.filter(a => a.status === 'present').length}
                                </p>
                            </div>
                            <div className="text-2xl">✅</div>
                        </div>
                    </div>

                    <div className="bg-orange-50 border border-orange-200 rounded-lg p-4">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-orange-600">Late Days</p>
                                <p className="text-xl font-bold text-orange-700">
                                    {attendance.data.filter(a => a.status === 'late').length}
                                </p>
                            </div>
                            <div className="text-2xl">⏰</div>
                        </div>
                    </div>

                    <div className="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-red-600">Absent Days</p>
                                <p className="text-xl font-bold text-red-700">
                                    {attendance.data.filter(a => a.status === 'absent').length}
                                </p>
                            </div>
                            <div className="text-2xl">❌</div>
                        </div>
                    </div>

                    <div className="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-blue-600">Total Hours</p>
                                <p className="text-xl font-bold text-blue-700">
                                    {Math.round(attendance.data.reduce((sum, a) => sum + (a.work_hours || 0), 0) / 60)}h
                                </p>
                            </div>
                            <div className="text-2xl">⏱️</div>
                        </div>
                    </div>
                </div>

                {/* Attendance Records */}
                <div className="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div className="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 className="text-lg font-semibold text-gray-900">Attendance Records</h3>
                        <p className="text-sm text-gray-600">Showing {attendance.data.length} of {attendance.total} records</p>
                    </div>

                    {attendance.data.length > 0 ? (
                        <>
                            <div className="overflow-x-auto">
                                <table className="min-w-full divide-y divide-gray-200">
                                    <thead className="bg-gray-50">
                                        <tr>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Date
                                            </th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Check In
                                            </th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Check Out
                                            </th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Work Hours
                                            </th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Location
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody className="bg-white divide-y divide-gray-200">
                                        {attendance.data.map((record) => (
                                            <tr key={record.id} className="hover:bg-gray-50">
                                                <td className="px-6 py-4 whitespace-nowrap">
                                                    <div className="text-sm font-medium text-gray-900">
                                                        {formatDate(record.date)}
                                                    </div>
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap">
                                                    <div className="text-sm text-gray-900">
                                                        {formatTime(record.check_in_time)}
                                                    </div>
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap">
                                                    <div className="text-sm text-gray-900">
                                                        {formatTime(record.check_out_time)}
                                                    </div>
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap">
                                                    <div className="text-sm text-gray-900">
                                                        {formatWorkHours(record.work_hours)}
                                                    </div>
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap">
                                                    <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border ${getStatusColor(record.status)}`}>
                                                        {getStatusIcon(record.status)} {record.status}
                                                    </span>
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {record.latitude_in && record.longitude_in ? (
                                                        <div className="space-y-1">
                                                            <div className="flex items-center space-x-1">
                                                                <span className="text-green-600">📍</span>
                                                                <span className="text-xs">
                                                                    {record.latitude_in.toFixed(4)}, {record.longitude_in.toFixed(4)}
                                                                </span>
                                                            </div>
                                                            {record.latitude_out && record.longitude_out && (
                                                                <div className="flex items-center space-x-1">
                                                                    <span className="text-red-600">🚪</span>
                                                                    <span className="text-xs">
                                                                        {record.latitude_out.toFixed(4)}, {record.longitude_out.toFixed(4)}
                                                                    </span>
                                                                </div>
                                                            )}
                                                        </div>
                                                    ) : (
                                                        <span className="text-gray-400">--</span>
                                                    )}
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>

                            {/* Pagination */}
                            {attendance.last_page > 1 && (
                                <div className="px-6 py-4 bg-gray-50 border-t border-gray-200">
                                    <div className="flex items-center justify-between">
                                        <div className="text-sm text-gray-700">
                                            Page {attendance.current_page} of {attendance.last_page}
                                        </div>
                                        <div className="flex space-x-2">
                                            {/* Add pagination buttons here if needed */}
                                        </div>
                                    </div>
                                </div>
                            )}
                        </>
                    ) : (
                        <div className="px-6 py-12 text-center">
                            <div className="text-4xl mb-4">📊</div>
                            <h3 className="text-lg font-medium text-gray-900 mb-2">No attendance records found</h3>
                            <p className="text-gray-600">Your attendance records will appear here once you start checking in.</p>
                        </div>
                    )}
                </div>
            </div>
        </AppShell>
    );
}