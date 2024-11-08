<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('employers', function (Blueprint $table) {
            if (!Schema::hasColumn('employers', 'street_address')) {
                $table->string('street_address')->nullable()->after('website');
            }
            if (!Schema::hasColumn('employers', 'country')) {
                $table->string('country')->nullable()->after('state');
            }
            if (!Schema::hasColumn('employers', 'postal_code')) {
                $table->string('postal_code')->nullable()->after('country');
            }
            if (!Schema::hasColumn('employers', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable()->after('postal_code');
            }
            if (!Schema::hasColumn('employers', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            }
        });
    }

    public function down(): void
    {
        Schema::table('employers', function (Blueprint $table) {
            $columns = ['street_address', 'country', 'postal_code', 'latitude', 'longitude'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('employers', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};