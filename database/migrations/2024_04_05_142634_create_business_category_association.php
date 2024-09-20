<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (! Schema::hasTable('business_category_associations')) {
            Schema::create('business_category_associations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('business_id');
                $table->unsignedBigInteger('category_id');
                $table->timestamps();

                $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
                $table->foreign('category_id')->references('id')->on('business_categories')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        // This should correctly reference the table being created
        Schema::dropIfExists('business_category_associations');
    }
};
