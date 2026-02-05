<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColorFieldsToSlidersTable extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::table('sliders', function (Blueprint $table) {
			// Per-element text colors
			$table->string('heading_color', 20)->nullable()->after('sub_heading');
			$table->string('sub_heading_color', 20)->nullable()->after('heading_color');
			$table->string('paragraph_color', 20)->nullable()->after('paragraph');

			// CTA button colors
			$table->string('button_text_color', 20)->nullable()->after('button_name');
			$table->string('button_bg_color', 20)->nullable()->after('button_text_color');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('sliders', function (Blueprint $table) {
			$table->dropColumn([
				'heading_color',
				'sub_heading_color',
				'paragraph_color',
				'button_text_color',
				'button_bg_color',
			]);
		});
	}
}