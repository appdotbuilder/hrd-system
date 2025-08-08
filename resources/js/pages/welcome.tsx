import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLogo from '@/components/app-logo';

export default function Welcome() {
    return (
        <>
            <Head title="HRD Management System" />
            <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
                {/* Header */}
                <header className="bg-white/80 backdrop-blur-sm border-b border-gray-200 sticky top-0 z-50">
                    <div className="container mx-auto px-4 py-4">
                        <div className="flex items-center justify-between">
                            <div className="flex items-center space-x-3">
                                <div className="h-10 w-10">
                                    <AppLogo />
                                </div>
                                <div>
                                    <h1 className="text-xl font-bold text-gray-900">HRD Management</h1>
                                    <p className="text-sm text-gray-600">Human Resource System</p>
                                </div>
                            </div>
                            <div className="flex items-center space-x-4">
                                <Link
                                    href="/login"
                                    className="text-gray-700 hover:text-blue-600 font-medium transition-colors"
                                >
                                    Login
                                </Link>
                                <Link
                                    href="/register"
                                    className="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 transition-colors shadow-sm font-medium"
                                >
                                    Get Started
                                </Link>
                            </div>
                        </div>
                    </div>
                </header>

                {/* Hero Section */}
                <section className="py-20">
                    <div className="container mx-auto px-4 text-center">
                        <div className="max-w-4xl mx-auto">
                            <div className="text-6xl mb-6">👥</div>
                            <h1 className="text-5xl font-bold text-gray-900 mb-6">
                                Complete HRD Management System
                            </h1>
                            <p className="text-xl text-gray-600 mb-8 leading-relaxed">
                                Streamline your human resources operations with our comprehensive platform
                                featuring employee management, GPS attendance, leave tracking, and more.
                            </p>
                            <div className="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                                <Link
                                    href="/register"
                                    className="bg-blue-600 text-white px-8 py-4 rounded-lg hover:bg-blue-700 transition-colors shadow-lg font-semibold text-lg"
                                >
                                    🚀 Start Free Trial
                                </Link>
                                <Link
                                    href="/login"
                                    className="bg-white text-gray-900 px-8 py-4 rounded-lg hover:bg-gray-50 transition-colors border-2 border-gray-200 font-semibold text-lg"
                                >
                                    📊 View Demo
                                </Link>
                            </div>

                            {/* Key Stats */}
                            <div className="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-3xl mx-auto">
                                <div className="bg-white/70 backdrop-blur-sm rounded-xl p-6 shadow-sm border border-gray-200">
                                    <div className="text-3xl font-bold text-blue-600 mb-2">15+</div>
                                    <div className="text-gray-700 font-medium">Database Tables</div>
                                    <div className="text-sm text-gray-500">Comprehensive data structure</div>
                                </div>
                                <div className="bg-white/70 backdrop-blur-sm rounded-xl p-6 shadow-sm border border-gray-200">
                                    <div className="text-3xl font-bold text-green-600 mb-2">GPS</div>
                                    <div className="text-gray-700 font-medium">Attendance Tracking</div>
                                    <div className="text-sm text-gray-500">Location-based check-in</div>
                                </div>
                                <div className="bg-white/70 backdrop-blur-sm rounded-xl p-6 shadow-sm border border-gray-200">
                                    <div className="text-3xl font-bold text-purple-600 mb-2">4</div>
                                    <div className="text-gray-700 font-medium">User Roles</div>
                                    <div className="text-sm text-gray-500">Role-based access control</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Features Section */}
                <section className="py-20 bg-white/50">
                    <div className="container mx-auto px-4">
                        <div className="text-center mb-16">
                            <h2 className="text-3xl font-bold text-gray-900 mb-4">🎯 Key Features</h2>
                            <p className="text-lg text-gray-600 max-w-2xl mx-auto">
                                Everything you need to manage your human resources effectively
                            </p>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {/* Employee Management */}
                            <div className="bg-white rounded-xl p-8 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                                <div className="text-4xl mb-4">👤</div>
                                <h3 className="text-xl font-bold text-gray-900 mb-3">Employee Management</h3>
                                <p className="text-gray-600 mb-4">
                                    Complete employee profiles with personal info, departments, positions, and role management.
                                </p>
                                <ul className="text-sm text-gray-500 space-y-1">
                                    <li>• Personal information tracking</li>
                                    <li>• Department & position assignment</li>
                                    <li>• Role-based permissions</li>
                                    <li>• Employment status management</li>
                                </ul>
                            </div>

                            {/* GPS Attendance */}
                            <div className="bg-white rounded-xl p-8 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                                <div className="text-4xl mb-4">📍</div>
                                <h3 className="text-xl font-bold text-gray-900 mb-3">GPS Attendance System</h3>
                                <p className="text-gray-600 mb-4">
                                    Location-based attendance tracking with automatic work hours calculation.
                                </p>
                                <ul className="text-sm text-gray-500 space-y-1">
                                    <li>• GPS-based check-in/check-out</li>
                                    <li>• Automatic work hours tracking</li>
                                    <li>• Late arrival detection</li>
                                    <li>• Attendance reports & analytics</li>
                                </ul>
                            </div>

                            {/* Leave Management */}
                            <div className="bg-white rounded-xl p-8 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                                <div className="text-4xl mb-4">📅</div>
                                <h3 className="text-xl font-bold text-gray-900 mb-3">Leave Management</h3>
                                <p className="text-gray-600 mb-4">
                                    Comprehensive leave system with approval workflows and balance tracking.
                                </p>
                                <ul className="text-sm text-gray-500 space-y-1">
                                    <li>• Multiple leave types support</li>
                                    <li>• Approval workflow system</li>
                                    <li>• Leave balance tracking</li>
                                    <li>• Calendar integration</li>
                                </ul>
                            </div>

                            {/* Payroll System */}
                            <div className="bg-white rounded-xl p-8 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                                <div className="text-4xl mb-4">💰</div>
                                <h3 className="text-xl font-bold text-gray-900 mb-3">Payroll System</h3>
                                <p className="text-gray-600 mb-4">
                                    Automated payroll processing with salary calculations and tax deductions.
                                </p>
                                <ul className="text-sm text-gray-500 space-y-1">
                                    <li>• Automated salary calculations</li>
                                    <li>• Tax & deduction management</li>
                                    <li>• Payroll reports generation</li>
                                    <li>• Bonus & allowance tracking</li>
                                </ul>
                            </div>

                            {/* Training Programs */}
                            <div className="bg-white rounded-xl p-8 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                                <div className="text-4xl mb-4">🎓</div>
                                <h3 className="text-xl font-bold text-gray-900 mb-3">Training & Development</h3>
                                <p className="text-gray-600 mb-4">
                                    Manage training programs, track certifications, and monitor employee development.
                                </p>
                                <ul className="text-sm text-gray-500 space-y-1">
                                    <li>• Training program management</li>
                                    <li>• Certificate tracking</li>
                                    <li>• Skills development monitoring</li>
                                    <li>• Training effectiveness reports</li>
                                </ul>
                            </div>

                            {/* Performance Reviews */}
                            <div className="bg-white rounded-xl p-8 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                                <div className="text-4xl mb-4">⭐</div>
                                <h3 className="text-xl font-bold text-gray-900 mb-3">Performance Management</h3>
                                <p className="text-gray-600 mb-4">
                                    Comprehensive performance evaluation system with goal tracking and reviews.
                                </p>
                                <ul className="text-sm text-gray-500 space-y-1">
                                    <li>• Regular performance reviews</li>
                                    <li>• Goal setting & tracking</li>
                                    <li>• 360-degree feedback</li>
                                    <li>• Performance analytics</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Dashboard Preview */}
                <section className="py-20">
                    <div className="container mx-auto px-4">
                        <div className="text-center mb-16">
                            <h2 className="text-3xl font-bold text-gray-900 mb-4">📊 Real-time Dashboard</h2>
                            <p className="text-lg text-gray-600 max-w-2xl mx-auto">
                                Get instant insights with our comprehensive dashboard showing all key metrics
                            </p>
                        </div>

                        <div className="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-8 text-white">
                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <div className="bg-white/20 rounded-lg p-6 backdrop-blur-sm">
                                    <div className="text-3xl font-bold mb-2">247</div>
                                    <div className="text-blue-100">Total Employees</div>
                                </div>
                                <div className="bg-white/20 rounded-lg p-6 backdrop-blur-sm">
                                    <div className="text-3xl font-bold mb-2">189</div>
                                    <div className="text-blue-100">Present Today</div>
                                </div>
                                <div className="bg-white/20 rounded-lg p-6 backdrop-blur-sm">
                                    <div className="text-3xl font-bold mb-2">12</div>
                                    <div className="text-blue-100">Pending Leaves</div>
                                </div>
                                <div className="bg-white/20 rounded-lg p-6 backdrop-blur-sm">
                                    <div className="text-3xl font-bold mb-2">5</div>
                                    <div className="text-blue-100">Departments</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* User Roles */}
                <section className="py-20 bg-gray-50">
                    <div className="container mx-auto px-4">
                        <div className="text-center mb-16">
                            <h2 className="text-3xl font-bold text-gray-900 mb-4">🔐 Role-Based Access Control</h2>
                            <p className="text-lg text-gray-600 max-w-2xl mx-auto">
                                Secure access with different permission levels for each user role
                            </p>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div className="bg-white rounded-xl p-6 shadow-sm border border-gray-200 text-center">
                                <div className="text-4xl mb-4">👑</div>
                                <h3 className="text-lg font-bold text-gray-900 mb-2">Administrator</h3>
                                <p className="text-sm text-gray-600 mb-4">Full system access and control</p>
                                <div className="bg-red-50 text-red-700 text-xs px-3 py-1 rounded-full inline-block">
                                    All Permissions
                                </div>
                            </div>

                            <div className="bg-white rounded-xl p-6 shadow-sm border border-gray-200 text-center">
                                <div className="text-4xl mb-4">👩‍💼</div>
                                <h3 className="text-lg font-bold text-gray-900 mb-2">HR Manager</h3>
                                <p className="text-sm text-gray-600 mb-4">Employee & HR operations management</p>
                                <div className="bg-blue-50 text-blue-700 text-xs px-3 py-1 rounded-full inline-block">
                                    HR Operations
                                </div>
                            </div>

                            <div className="bg-white rounded-xl p-6 shadow-sm border border-gray-200 text-center">
                                <div className="text-4xl mb-4">👨‍💼</div>
                                <h3 className="text-lg font-bold text-gray-900 mb-2">Manager</h3>
                                <p className="text-sm text-gray-600 mb-4">Department oversight and approvals</p>
                                <div className="bg-green-50 text-green-700 text-xs px-3 py-1 rounded-full inline-block">
                                    Team Management
                                </div>
                            </div>

                            <div className="bg-white rounded-xl p-6 shadow-sm border border-gray-200 text-center">
                                <div className="text-4xl mb-4">👤</div>
                                <h3 className="text-lg font-bold text-gray-900 mb-2">Employee</h3>
                                <p className="text-sm text-gray-600 mb-4">Personal profile and attendance</p>
                                <div className="bg-gray-50 text-gray-700 text-xs px-3 py-1 rounded-full inline-block">
                                    Self Service
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* CTA Section */}
                <section className="py-20 bg-gradient-to-r from-blue-600 to-indigo-600">
                    <div className="container mx-auto px-4 text-center">
                        <div className="max-w-3xl mx-auto text-white">
                            <h2 className="text-4xl font-bold mb-6">Ready to Transform Your HR Operations? 🚀</h2>
                            <p className="text-xl mb-8 text-blue-100">
                                Join hundreds of companies that have streamlined their HR processes with our comprehensive system.
                            </p>
                            <div className="flex flex-col sm:flex-row gap-4 justify-center">
                                <Link
                                    href="/register"
                                    className="bg-white text-blue-600 px-8 py-4 rounded-lg hover:bg-gray-100 transition-colors shadow-lg font-semibold text-lg"
                                >
                                    🎯 Start Your Free Trial
                                </Link>
                                <Link
                                    href="/login"
                                    className="bg-blue-700 text-white px-8 py-4 rounded-lg hover:bg-blue-800 transition-colors border-2 border-blue-400 font-semibold text-lg"
                                >
                                    💼 Access Dashboard
                                </Link>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Footer */}
                <footer className="bg-gray-900 text-gray-300 py-12">
                    <div className="container mx-auto px-4">
                        <div className="flex flex-col md:flex-row items-center justify-between">
                            <div className="flex items-center space-x-3 mb-4 md:mb-0">
                                <div className="h-8 w-8">
                                    <AppLogo />
                                </div>
                                <div>
                                    <div className="font-bold text-white">HRD Management System</div>
                                    <div className="text-sm text-gray-400">Complete HR Solution</div>
                                </div>
                            </div>
                            <div className="text-sm text-gray-400">
                                © {new Date().getFullYear()} HRD Management System. All rights reserved.
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}