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
        Schema::table('transaksies', function (Blueprint $table) {
            $table->string('telepon', 50)->change();
        });

        Schema::table('cars', function (Blueprint $table) {
            $table->enum('status', ['tersedia', 'disewakan', 'dibooking'])->default('tersedia')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->enum('status', ['tersedia', 'disewakan'])->default('tersedia')->change();
        });

        Schema::table('transaksies', function (Blueprint $table) {
            $table->date('telepon')->change();
        });
    }
};
