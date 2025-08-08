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
        Schema::create('hrd_work_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Schedule name');
            $table->time('start_time')->comment('Work start time');
            $table->time('end_time')->comment('Work end time');
            $table->integer('break_duration')->default(60)->comment('Break duration in minutes');
            $table->json('work_days')->comment('Working days (0=Sunday, 6=Saturday)');
            $table->boolean('is_flexible')->default(false)->comment('Flexible schedule flag');
            $table->integer('flex_start_range')->nullable()->comment('Flexible start range in minutes');
            $table->integer('flex_end_range')->nullable()->comment('Flexible end range in minutes');
            $table->boolean('is_active')->default(true)->comment('Schedule status');
            $table->timestamps();
            
            $table->index(['name', 'is_active']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrd_work_schedules');
    }
};