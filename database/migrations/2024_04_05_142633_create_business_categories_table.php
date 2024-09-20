<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('business_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('parent_id')->nullable();  // nullable because top-level categories won't have a parent
            $table->foreign('parent_id')->references('id')->on('business_categories')->onDelete('cascade');  // optional cascade on delete
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('business_categories');
    }
};