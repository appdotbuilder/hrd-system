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
        Schema::create('hrd_leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('Leave type name');
            $table->string('code', 10)->unique()->comment('Leave type code');
            $table->text('description')->nullable()->comment('Leave type description');
            $table->integer('max_days_per_year')->nullable()->comment('Maximum days allowed per year');
            $table->boolean('requires_approval')->default(true)->comment('Whether approval is required');
            $table->boolean('is_paid')->default(true)->comment('Whether leave is paid');
            $table->boolean('is_active')->default(true)->comment('Leave type status');
            $table->timestamps();
            
            $table->index(['name', 'is_active']);
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrd_leave_types');
    }
};