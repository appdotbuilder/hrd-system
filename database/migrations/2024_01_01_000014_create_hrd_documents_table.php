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
        Schema::create('hrd_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->comment('Document owner employee ID');
            $table->string('title')->comment('Document title');
            $table->enum('type', ['contract', 'identification', 'certificate', 'medical', 'performance', 'other'])->comment('Document type');
            $table->string('file_path')->comment('File storage path');
            $table->string('file_name')->comment('Original file name');
            $table->string('mime_type')->comment('File MIME type');
            $table->integer('file_size')->comment('File size in bytes');
            $table->text('description')->nullable()->comment('Document description');
            $table->date('issue_date')->nullable()->comment('Document issue date');
            $table->date('expiry_date')->nullable()->comment('Document expiry date');
            $table->boolean('is_confidential')->default(false)->comment('Confidentiality flag');
            $table->unsignedBigInteger('uploaded_by')->comment('Uploader user ID');
            $table->timestamps();
            
            $table->foreign('employee_id')->references('id')->on('hrd_employees')->onDelete('cascade');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('restrict');
            $table->index(['employee_id', 'type']);
            $table->index('type');
            $table->index('expiry_date');
            $table->index('uploaded_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrd_documents');
    }
};