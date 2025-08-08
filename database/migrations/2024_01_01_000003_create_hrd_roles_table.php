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
        Schema::create('hrd_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('Role name (admin, hr, manager, employee)');
            $table->string('display_name')->comment('Human readable role name');
            $table->text('description')->nullable()->comment('Role description');
            $table->json('permissions')->nullable()->comment('Role permissions');
            $table->timestamps();
            
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrd_roles');
    }
};