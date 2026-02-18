<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('image_desktop')->nullable()->after('image');
            $table->string('image_mobile')->nullable()->after('image_desktop');
        });

        // Backfill desktop image from legacy 'image' column
        $rows = DB::table('sliders')->select('id', 'image')->get();
        foreach ($rows as $row) {
            if (!empty($row->image)) {
                DB::table('sliders')->where('id', $row->id)->update([
                    'image_desktop' => $row->image,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['image_desktop', 'image_mobile']);
        });
    }
};
