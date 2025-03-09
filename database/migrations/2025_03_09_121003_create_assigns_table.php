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
        Schema::create('assigns', function (Blueprint $table) {
            $table->id(); // Primary Key (Auto-incrementing)
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('asset_id')->constrained('product_items');
            $table->foreignId('assigned_by')->constrained('users');
            $table->timestamp('assigned_at')->useCurrent();
            $table->enum('assign_condition', ['New', 'Good', 'Damaged'])->default('Good');
            $table->integer('total_items')->default(1);
            $table->date('deadline')->nullable();
            $table->foreignId('store_id')->constrained('stores');
            $table->string('serial_no')->nullable();
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->enum('return_condition', ['New', 'Good', 'Damaged'])->nullable();
            $table->text('return_reason')->nullable();
            $table->timestamp('date_returned')->nullable();
            $table->text('comment')->nullable();
            $table->enum('status', ['pending', 'approved', 'returned'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigns');
    }
};
