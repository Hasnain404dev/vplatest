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
            $table->string('slug')->unique(); // Added slug field
            $table->text('description')->nullable();
            $table->text('longDescription')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('discountprice', 10, 2)->nullable();
            $table->decimal('discount', 5, 2)->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->string('material')->nullable();
            $table->string('shape')->nullable();
            $table->string('rim')->nullable();
            $table->string('category')->nullable();
            $table->unsignedBigInteger('lenses_prescription_id')->nullable();
            $table->string('status')->nullable();
            $table->string('tags')->nullable();
            $table->string('stock')->nullable();
            $table->string('main_image')->nullable(); // single image
            $table->string('virtual_try_on_image')->nullable(); // Added virtual try on image field
            $table->string('threeD_try_on_name')->nullable(); // Added 3D try on name field

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
