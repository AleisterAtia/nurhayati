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
        Schema::create('orders', function (Blueprint $table) {
         $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('address_id')->constrained('addresses')->onDelete('cascade');
        $table->foreignId('shipping_method_id')->constrained('shipping_methods')->onDelete('cascade');
        $table->foreignId('payment_method_id')->constrained('payment_methods')->onDelete('cascade');

        $table->string('order_number')->unique();
        $table->decimal('subtotal', 12, 2);
        $table->decimal('shipping_cost', 10, 2); // Biaya ongkir saat order
        $table->decimal('total_amount', 12, 2);
        $table->enum('status', ['pending', 'processing', 'shipped', 'completed', 'cancelled'])->default('pending');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
