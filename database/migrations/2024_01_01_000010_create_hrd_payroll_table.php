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
        Schema::create('hrd_payroll', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->comment('Employee ID');
            $table->string('period', 7)->comment('Payroll period (YYYY-MM)');
            $table->decimal('basic_salary', 15, 2)->comment('Basic salary amount');
            $table->decimal('allowances', 15, 2)->default(0)->comment('Total allowances');
            $table->decimal('overtime_pay', 15, 2)->default(0)->comment('Overtime payment');
            $table->decimal('bonuses', 15, 2)->default(0)->comment('Bonuses and incentives');
            $table->decimal('deductions', 15, 2)->default(0)->comment('Total deductions');
            $table->decimal('tax', 15, 2)->default(0)->comment('Tax deduction');
            $table->decimal('gross_salary', 15, 2)->comment('Gross salary (before deductions)');
            $table->decimal('net_salary', 15, 2)->comment('Net salary (after deductions)');
            $table->enum('status', ['draft', 'processed', 'paid'])->default('draft')->comment('Payroll status');
            $table->timestamp('processed_at')->nullable()->comment('Processing timestamp');
            $table->unsignedBigInteger('processed_by')->nullable()->comment('Processor user ID');
            $table->timestamps();
            
            $table->foreign('employee_id')->references('id')->on('hrd_employees')->onDelete('cascade');
            $table->foreign('processed_by')->references('id')->on('users')->onDelete('set null');
            $table->unique(['employee_id', 'period']);
            $table->index(['period', 'status']);
            $table->index('employee_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrd_payroll');
    }
};