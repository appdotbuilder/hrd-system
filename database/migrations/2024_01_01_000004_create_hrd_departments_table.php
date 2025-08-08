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
        Schema::create('hrd_departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Department name');
            $table->string('code', 10)->unique()->comment('Department code');
            $table->text('description')->nullable()->comment('Department description');
            $table->unsignedBigInteger('manager_id')->nullable()->comment('Department manager user ID');
            $table->boolean('is_active')->default(true)->comment('Department status');
            $table->timestamps();
            
            $table->index(['name', 'is_active']);
            $table->index('code');
            $table->index('manager_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrd_departments');
    }
};