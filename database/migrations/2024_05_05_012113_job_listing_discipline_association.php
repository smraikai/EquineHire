<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('job_listing_discipline_associations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_listing_id');
            $table->unsignedBigInteger('discipline_id');
            $table->timestamps();

            // Correct the table name for the discipline_id foreign key
            $table->foreign('job_listing_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->foreign('discipline_id')->references('id')->on('job_listing_disciplines')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_listing_discipline_associations');
    }
};
