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
        Schema::create('hrd_employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique()->comment('Related user ID');
            $table->string('employee_id', 20)->unique()->comment('Employee identification number');
            $table->string('first_name')->comment('Employee first name');
            $table->string('last_name')->comment('Employee last name');
            $table->string('phone')->nullable()->comment('Phone number');
            $table->date('birth_date')->nullable()->comment('Birth date');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->comment('Gender');
            $table->text('address')->nullable()->comment('Home address');
            $table->string('emergency_contact_name')->nullable()->comment('Emergency contact name');
            $table->string('emergency_contact_phone')->nullable()->comment('Emergency contact phone');
            $table->unsignedBigInteger('department_id')->nullable()->comment('Current department');
            $table->unsignedBigInteger('position_id')->nullable()->comment('Current position');
            $table->unsignedBigInteger('role_id')->default(4)->comment('User role (default: employee)');
            $table->date('hire_date')->comment('Date of hire');
            $table->date('termination_date')->nullable()->comment('Termination date if applicable');
            $table->enum('employment_status', ['active', 'inactive', 'terminated', 'suspended'])->default('active')->comment('Employment status');
            $table->decimal('salary', 15, 2)->nullable()->comment('Current salary');
            $table->string('profile_photo')->nullable()->comment('Profile photo path');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('hrd_departments')->onDelete('set null');
            $table->foreign('position_id')->references('id')->on('hrd_positions')->onDelete('set null');
            $table->foreign('role_id')->references('id')->on('hrd_roles')->onDelete('restrict');
            
            $table->index(['employee_id', 'employment_status']);
            $table->index(['first_name', 'last_name']);
            $table->index('department_id');
            $table->index('position_id');
            $table->index('role_id');
            $table->index('employment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrd_employees');
    }
};