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
        Schema::table('coupon_customers', function (Blueprint $table) {
            $table->string('phone_number')->nullable()->after('user_id');
            $table->string('email')->nullable()->after('phone_number');
            $table->index(['phone_number', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupon_customers', function (Blueprint $table) {
            $table->dropIndex(['phone_number', 'email']);
            $table->dropColumn(['phone_number', 'email']);
        });
    }
};

