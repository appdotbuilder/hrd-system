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
        Schema::create('hrd_employee_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->comment('Employee ID');
            $table->unsignedBigInteger('schedule_id')->comment('Work schedule ID');
            $table->date('effective_from')->comment('Schedule effective start date');
            $table->date('effective_to')->nullable()->comment('Schedule effective end date');
            $table->boolean('is_active')->default(true)->comment('Assignment status');
            $table->timestamps();
            
            $table->foreign('employee_id')->references('id')->on('hrd_employees')->onDelete('cascade');
            $table->foreign('schedule_id')->references('id')->on('hrd_work_schedules')->onDelete('restrict');
            $table->index(['employee_id', 'effective_from', 'effective_to']);
            $table->index('schedule_id');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrd_employee_schedules');
    }
};