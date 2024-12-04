<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->string('currency', 3)->default('USD')->after('salary_range_max');
        });
    }

    public function down()
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->dropColumn('currency');
        });
    }
};
