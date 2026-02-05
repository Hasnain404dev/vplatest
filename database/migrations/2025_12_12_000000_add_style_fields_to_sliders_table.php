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
        Schema::table('sliders', function (Blueprint $table) {
            $table->decimal('background_opacity', 3, 2)->nullable()->after('button_link')->comment('0-1, overlay darkness over image');
            $table->string('text_color', 20)->nullable()->after('background_opacity')->comment('Hex e.g. #ffffff');
            $table->string('button_color', 20)->nullable()->after('text_color')->comment('Hex e.g. #0d6efd');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['background_opacity', 'text_color', 'button_color']);
        });
    }
};
