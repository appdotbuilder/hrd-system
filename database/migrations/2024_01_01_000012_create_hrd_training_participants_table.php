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
        Schema::create('hrd_training_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_program_id')->comment('Training program ID');
            $table->unsignedBigInteger('employee_id')->comment('Participant employee ID');
            $table->timestamp('enrolled_at')->comment('Enrollment timestamp');
            $table->enum('status', ['enrolled', 'completed', 'dropped', 'failed'])->default('enrolled')->comment('Participation status');
            $table->decimal('score', 5, 2)->nullable()->comment('Final score (0-100)');
            $table->boolean('certificate_issued')->default(false)->comment('Certificate issuance status');
            $table->timestamp('completed_at')->nullable()->comment('Completion timestamp');
            $table->text('notes')->nullable()->comment('Additional notes');
            $table->timestamps();
            
            $table->foreign('training_program_id')->references('id')->on('hrd_training_programs')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('hrd_employees')->onDelete('cascade');
            $table->unique(['training_program_id', 'employee_id']);
            $table->index(['training_program_id', 'status']);
            $table->index('employee_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrd_training_participants');
    }
};