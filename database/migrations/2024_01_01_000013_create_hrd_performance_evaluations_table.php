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
        Schema::create('hrd_performance_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->comment('Employee being evaluated');
            $table->unsignedBigInteger('evaluator_id')->comment('Evaluator user ID');
            $table->string('period', 7)->comment('Evaluation period (YYYY-MM)');
            $table->enum('type', ['monthly', 'quarterly', 'annual', 'probation'])->comment('Evaluation type');
            $table->json('scores')->comment('Evaluation scores by criteria');
            $table->decimal('overall_score', 5, 2)->comment('Overall evaluation score');
            $table->text('strengths')->nullable()->comment('Employee strengths');
            $table->text('weaknesses')->nullable()->comment('Areas for improvement');
            $table->text('goals')->nullable()->comment('Goals for next period');
            $table->text('comments')->nullable()->comment('Additional comments');
            $table->enum('status', ['draft', 'completed', 'approved'])->default('draft')->comment('Evaluation status');
            $table->timestamp('completed_at')->nullable()->comment('Completion timestamp');
            $table->timestamps();
            
            $table->foreign('employee_id')->references('id')->on('hrd_employees')->onDelete('cascade');
            $table->foreign('evaluator_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['employee_id', 'period', 'type']);
            $table->index(['employee_id', 'period']);
            $table->index('evaluator_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrd_performance_evaluations');
    }
};