<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->text('description');
            $table->decimal('price');
            $table->integer('quantity');
            $table->integer('google_product_category', unsigned: true)->nullable();
            $table->integer('fb_product_category', unsigned: true)->nullable();
            $table->enum('gender', array('female', 'male', 'unisex'));
            $table->foreignUuid('brand_id')->references('id')->on('brands');
            $table->string('sku', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
