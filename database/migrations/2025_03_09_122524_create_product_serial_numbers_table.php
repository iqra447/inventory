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
        Schema::create('product_serial_numbers', function (Blueprint $table) {
            $table->id(); // Primary Key (Auto-incrementing)
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            // Links serial number to a product.

            $table->string('serial_no')->unique();
            // Unique serial number for each item.

            $table->string('color')->nullable();
            // Color of the product.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_serial_numbers');
    }
};
