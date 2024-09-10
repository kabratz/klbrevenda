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
        Schema::create('orders_products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('order_id')->references('id')->on('orders');
            $table->foreignUuid('product_id')->references('id')->on('products');
            $table->integer('quantity', unsigned:true)->nullable();
            $table->decimal('price', unsigned:true);
            $table->decimal('discount', unsigned:true)->nullable();
            $table->integer('discount_percent', unsigned:true)->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_products');
    }
};
