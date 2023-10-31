<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /* Run the migrations. */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('slug');
            $table->string('title');
            $table->string('image');
            $table->float('ratting');
            $table->json('size')->nullable();
            $table->integer('price');
            $table->integer('category_id');
            $table->longText('body')->nullable();
            $table->longText('plant_body')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /* Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
