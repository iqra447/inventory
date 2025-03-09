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
            $table->id();
            $table->string('name');
            $table->foreignId('product_type_id')->constrained('product_types');
            $table->foreignId('make_id')->constrained('makes');
            $table->foreignId('store_id')->constrained('stores');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('user_id')->constrained('users');
            $table->enum('condition', ['New', 'Good', 'Damaged'])->default('New');
            $table->integer('total_stock')->default(0);
            $table->integer('current_stock')->default(0);
            $table->text('description')->nullable(); // Optional description
            $table->integer('status')->default(1); // 0 = Inactive, 1 = Active
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
