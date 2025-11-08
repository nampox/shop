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
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade');
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->integer('reserved_quantity')->default(0); // Số lượng đã được đặt hàng nhưng chưa thanh toán
            $table->integer('available_quantity')->virtualAs('quantity - reserved_quantity'); // Số lượng có sẵn
            $table->timestamps();

            // Lưu ý: Logic kiểm tra product_id HOẶC variant_id sẽ được xử lý trong Model/Request validation
            // Vì MySQL có hạn chế với CHECK constraint
            
            // Indexes
            $table->index('product_id');
            $table->index('variant_id');
            $table->index(['product_id', 'variant_id']);
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

