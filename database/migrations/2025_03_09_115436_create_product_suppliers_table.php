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
        Schema::create('product_suppliers', function (Blueprint $table) {
            $table->id(); // Primary Key (Auto-incrementing)
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            // Links product supplier record to a product.

            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            // Links product supplier record to a supplier.

            $table->integer('quantity'); // Total quantity received from supplier
            $table->integer('num_in_stock'); // Quantity still in stock from supplier
            $table->integer('total_stock'); // Total stock received from supplier
            $table->enum('condition', ['New', 'Good', 'Damaged'])->default('New');
            // Tracks the condition of the product when supplied.

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // The user who registered the supply.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_suppliers');
    }
};
