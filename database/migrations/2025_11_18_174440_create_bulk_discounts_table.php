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
        Schema::create('bulk_discounts', function (Blueprint $table) {
    $table->id();
    $table->string('title')->nullable();
    $table->enum('discount_type', ['percentage','fixed'])->default('percentage');
    $table->decimal('discount_value', 10, 2)->default(0);
    $table->enum('scope', ['all','category','brand','products'])->default('all');
    $table->json('scope_meta')->nullable(); // e.g. { "category_ids": [1,2] }
    $table->boolean('active')->default(true);
    $table->timestamp('starts_at')->nullable();
    $table->timestamp('ends_at')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulk_discounts');
    }
};
