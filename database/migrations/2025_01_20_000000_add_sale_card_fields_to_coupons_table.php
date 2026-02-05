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
        Schema::table('coupons', function (Blueprint $table) {
            $table->boolean('show_sale_card')->default(false)->after('status');
            $table->string('card_color')->nullable()->after('show_sale_card');
            $table->string('card_gradient_from')->nullable()->after('card_color');
            $table->string('card_gradient_to')->nullable()->after('card_gradient_from');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['show_sale_card', 'card_color', 'card_gradient_from', 'card_gradient_to']);
        });
    }
};

