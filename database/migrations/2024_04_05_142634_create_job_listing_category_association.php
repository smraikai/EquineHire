<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('job_listing_category_associations')) {
            Schema::create('job_listing_category_associations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('job_listing_id');
                $table->unsignedBigInteger('job_listing_category_id');
                $table->timestamps();

                $table->foreign('job_listing_id')->references('id')->on('job_listings')->onDelete('cascade');
                $table->foreign('job_listing_category_id')->references('id')->on('job_listing_categories')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        // This should correctly reference the table being created
        Schema::dropIfExists('business_category_associations');
    }
};
