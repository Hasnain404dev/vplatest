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
        Schema::create('coupons', function (Blueprint $table) {
    $table->id();
    $table->string('code')->unique();
    $table->string('title')->nullable();
    $table->text('description')->nullable();
    $table->enum('discount_type', ['percentage','fixed'])->default('percentage');
    $table->decimal('discount_value', 10, 2)->default(0);
    $table->decimal('min_order_amount', 10, 2)->nullable();
    $table->enum('apply_on', ['cart','category','product','user'])->default('cart');
    $table->unsignedBigInteger('category_id')->nullable()->index();
    $table->unsignedBigInteger('product_id')->nullable()->index();
    $table->unsignedBigInteger('user_id')->nullable()->index();
    $table->timestamp('valid_from')->nullable()->index();
    $table->timestamp('valid_until')->nullable()->index();
    $table->integer('usage_limit')->nullable();
    $table->integer('usage_count')->default(0);
    $table->boolean('status')->default(true);
    $table->json('meta')->nullable(); // store extra rules (e.g., allowed brands)
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
