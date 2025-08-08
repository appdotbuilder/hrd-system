<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hrd_attendance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->comment('Employee ID');
            $table->date('date')->comment('Attendance date');
            $table->time('check_in_time')->nullable()->comment('Check-in time');
            $table->time('check_out_time')->nullable()->comment('Check-out time');
            $table->decimal('latitude_in', 10, 8)->nullable()->comment('Check-in GPS latitude');
            $table->decimal('longitude_in', 11, 8)->nullable()->comment('Check-in GPS longitude');
            $table->decimal('latitude_out', 10, 8)->nullable()->comment('Check-out GPS latitude');
            $table->decimal('longitude_out', 11, 8)->nullable()->comment('Check-out GPS longitude');
            $table->integer('work_hours')->nullable()->comment('Total work hours in minutes');
            $table->enum('status', ['present', 'late', 'absent', 'partial', 'holiday'])->default('present')->comment('Attendance status');
            $table->text('notes')->nullable()->comment('Additional notes');
            $table->timestamps();
            
            $table->foreign('employee_id')->references('id')->on('hrd_employees')->onDelete('cascade');
            $table->unique(['employee_id', 'date']);
            $table->index(['date', 'status']);
            $table->index('employee_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrd_attendance');
    }
};