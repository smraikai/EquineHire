<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('job_listings')) {
            Schema::create('job_listings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('employer_id')->constrained()->onDelete('cascade');
                $table->foreignId('category_id')->constrained('job_listing_categories')->onDelete('cascade');
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('description');
                $table->boolean('remote_position')->default(false);
                $table->string('city')->nullable();
                $table->string('state')->nullable();
                $table->string('job_type');
                $table->string('experience_required');
                $table->string('salary_type')->nullable();
                $table->decimal('hourly_rate_min', 10, 2)->nullable();
                $table->decimal('hourly_rate_max', 10, 2)->nullable();
                $table->decimal('salary_range_min', 12, 2)->nullable();
                $table->decimal('salary_range_max', 12, 2)->nullable();
                $table->string('application_type')->nullable();
                $table->string('application_link')->nullable();
                $table->string('email_link')->nullable();
                $table->boolean('is_active')->default(true);
                $table->boolean('is_boosted')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};