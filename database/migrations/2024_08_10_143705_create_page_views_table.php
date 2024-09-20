<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageViewsTable extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('page_views')) {
            Schema::create('page_views', function (Blueprint $table) {
                $table->id();
                $table->foreignId('business_id')->constrained()->onDelete('cascade');
                $table->integer('view_count');
                $table->date('date');
                $table->timestamps();

                $table->index(['business_id', 'date']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('page_views');
    }
}
