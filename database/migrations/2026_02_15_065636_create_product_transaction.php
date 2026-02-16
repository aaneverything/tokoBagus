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
            $table->bigInteger('users_id');
            $table->text('address')->nullable();
            $table->string('payment')->default('manual');
            $table->float('total_price');
            $table->float('shipping_price');
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
