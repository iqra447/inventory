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
        Schema::create('product_items', function (Blueprint $table) {
            $table->id(); // Primary Key (Auto-incrementing)
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            // Links product item to a product.

            $table->string('serial_no')->unique();
            // Unique serial number for each item.

            $table->enum('condition', ['New', 'Good', 'Damaged'])->default('New');
            // Tracks the condition of the product item.

            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            // User/Department that this product item is assigned to.

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // The user who registered the product item.

            $table->integer('status')->default(1); // 0 = Inactive, 1 = Active
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_items');
    }
};
