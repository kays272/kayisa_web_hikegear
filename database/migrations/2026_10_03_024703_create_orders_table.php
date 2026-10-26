<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('address_id')
                ->nullable()
                ->constrained('addresses')
                ->nullOnDelete();

            $table->string('order_number')->unique();

            // Snapshot alamat saat checkout
            $table->string('recipient_name');
            $table->string('phone', 20);
            $table->string('province');
            $table->string('city');
            $table->string('district');
            $table->text('address');
            $table->string('postal_code', 10);

            $table->decimal('subtotal', 15, 2);
            $table->decimal('shipping_cost', 15, 2)->default(0);
            $table->decimal('total', 15, 2);

            $table->string('shipping_courier');
            $table->string('shipping_service');

            $table->enum('payment_method', [
                'bank_transfer',
                'qris',
                'cod'
            ]);

            $table->enum('payment_status', [
                'pending',
                'waiting_verification',
                'verified',
                'rejected'
            ])->default('pending');

            $table->enum('order_status', [
                'pending_payment',
                'waiting_verification',
                'payment_verified',
                'processing',
                'shipped',
                'completed',
                'cancelled'
            ])->default('pending_payment');

            $table->text('cancellation_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};