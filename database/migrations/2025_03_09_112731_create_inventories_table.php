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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id(); // Primary Key (Auto-incrementing)
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            // Links inventory record to a product.

            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            // Links inventory record to a store.

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Links inventory record to the user who added the stock.

            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('set null');
            // Links inventory record to a supplier (nullable in case stock is added internally).

            $table->integer('current_stock'); // Stock level before this transaction
            $table->integer('stock_added'); // Amount of stock added
            $table->integer('new_stock'); // Stock level after this transaction

            $table->timestamp('date_added')->useCurrent(); // Timestamp of the stock update
            $table->integer('status')->default(1); // 0 = Inactive, 1 = Active

            $table->timestamps(); // Laravel's created_at & updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
