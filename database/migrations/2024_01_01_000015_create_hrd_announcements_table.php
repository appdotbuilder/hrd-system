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
        Schema::create('hrd_announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Announcement title');
            $table->text('content')->comment('Announcement content');
            $table->enum('type', ['general', 'policy', 'event', 'urgent', 'holiday'])->default('general')->comment('Announcement type');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal')->comment('Announcement priority');
            $table->json('target_roles')->nullable()->comment('Target user roles');
            $table->json('target_departments')->nullable()->comment('Target departments');
            $table->boolean('is_active')->default(true)->comment('Announcement status');
            $table->timestamp('published_at')->nullable()->comment('Publication timestamp');
            $table->timestamp('expires_at')->nullable()->comment('Expiration timestamp');
            $table->unsignedBigInteger('created_by')->comment('Creator user ID');
            $table->timestamps();
            
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->index(['type', 'is_active']);
            $table->index(['priority', 'published_at']);
            $table->index('created_by');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrd_announcements');
    }
};