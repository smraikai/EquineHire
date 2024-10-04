<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_employer')->default(false);
        });

        // Drop the foreign key constraint if it exists (for MySQL)
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['user_type_id']);
            });
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_type_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_type_id')->nullable();
            $table->dropColumn('is_employer');
        });

        // Add back the foreign key constraint (for MySQL)
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('users', function (Blueprint $table) {
                $table->foreign('user_type_id')->references('id')->on('user_types');
            });
        }
    }
};