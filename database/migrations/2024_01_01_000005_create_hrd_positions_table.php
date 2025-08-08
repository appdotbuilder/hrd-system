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
        Schema::create('hrd_positions', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Position title');
            $table->string('code', 10)->unique()->comment('Position code');
            $table->unsignedBigInteger('department_id')->comment('Related department ID');
            $table->text('description')->nullable()->comment('Position description');
            $table->decimal('min_salary', 15, 2)->nullable()->comment('Minimum salary for this position');
            $table->decimal('max_salary', 15, 2)->nullable()->comment('Maximum salary for this position');
            $table->boolean('is_active')->default(true)->comment('Position status');
            $table->timestamps();
            
            $table->foreign('department_id')->references('id')->on('hrd_departments')->onDelete('cascade');
            $table->index(['title', 'is_active']);
            $table->index('code');
            $table->index('department_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrd_positions');
    }
};