<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_transaction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users')->cascadeOnDelete();
            $table->text('address')->nullable();
            $table->string('payment')->default('manual');
            $table->decimal('total_price', 12, 2)->default(0);
            $table->decimal('shipping_price', 12, 2)->default(0);
            $table->string('status')->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('product_transaction');
    }
};
