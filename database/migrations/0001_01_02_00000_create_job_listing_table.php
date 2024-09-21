<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->boolean('remote_position')->default(false);
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('job_type');
            $table->string('experience_required');
            $table->string('salary_type');
            $table->decimal('hourly_rate_min', 10, 2)->nullable();
            $table->decimal('hourly_rate_max', 10, 2)->nullable();
            $table->decimal('salary_range_min', 12, 2)->nullable();
            $table->decimal('salary_range_max', 12, 2)->nullable();
            $table->string('application_type');
            $table->string('application_link')->nullable();
            $table->string('email_link')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_boosted')->default(false);
            $table->boolean('is_sticky')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};