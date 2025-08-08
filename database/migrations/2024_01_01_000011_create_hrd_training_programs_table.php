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
        Schema::create('hrd_training_programs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Training program name');
            $table->string('code', 20)->unique()->comment('Training program code');
            $table->text('description')->nullable()->comment('Program description');
            $table->string('instructor')->nullable()->comment('Training instructor');
            $table->integer('duration_hours')->comment('Duration in hours');
            $table->decimal('cost', 15, 2)->nullable()->comment('Training cost');
            $table->date('start_date')->nullable()->comment('Program start date');
            $table->date('end_date')->nullable()->comment('Program end date');
            $table->integer('max_participants')->nullable()->comment('Maximum participants');
            $table->enum('status', ['planned', 'ongoing', 'completed', 'cancelled'])->default('planned')->comment('Program status');
            $table->timestamps();
            
            $table->index(['name', 'status']);
            $table->index('code');
            $table->index(['start_date', 'end_date']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrd_training_programs');
    }
};