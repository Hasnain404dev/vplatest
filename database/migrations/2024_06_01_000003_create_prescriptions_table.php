
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('session_id')->nullable();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('lens_type');
            $table->string('lens_feature')->nullable();
            $table->string('lens_option')->nullable();
            $table->decimal('lens_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->string('prescription_type');
            $table->json('prescription_data')->nullable();
            $table->boolean('image_uploaded')->default(false);
            $table->string('prescription_image')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();

            // Ensure a product is only added once per user or session
            $table->index(['user_id', 'product_id']);
            $table->index(['session_id', 'product_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('prescriptions');
    }
};

