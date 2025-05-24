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
        Schema::table('hotels', function (Blueprint $table) {
//            $table->text('description')->nullable()->comment('hotel description')->after('file_path');
            $table->string('hotel_image_path')->nullable()->comment('hotel image path')->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('hotel_image_path');
        });
    }
};
