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
        Schema::create('hrd_leave_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->comment('Employee requesting leave');
            $table->unsignedBigInteger('leave_type_id')->comment('Type of leave requested');
            $table->date('start_date')->comment('Leave start date');
            $table->date('end_date')->comment('Leave end date');
            $table->integer('total_days')->comment('Total leave days requested');
            $table->text('reason')->comment('Reason for leave request');
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending')->comment('Request status');
            $table->unsignedBigInteger('approved_by')->nullable()->comment('Approver user ID');
            $table->timestamp('approved_at')->nullable()->comment('Approval timestamp');
            $table->text('approval_notes')->nullable()->comment('Approval/rejection notes');
            $table->timestamps();
            
            $table->foreign('employee_id')->references('id')->on('hrd_employees')->onDelete('cascade');
            $table->foreign('leave_type_id')->references('id')->on('hrd_leave_types')->onDelete('restrict');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            
            $table->index(['employee_id', 'status']);
            $table->index(['start_date', 'end_date']);
            $table->index('status');
            $table->index('leave_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrd_leave_requests');
    }
};