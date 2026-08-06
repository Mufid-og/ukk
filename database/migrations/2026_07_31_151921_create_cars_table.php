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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_kelas');
            $table->unsignedBigInteger('id_brand');

            $table->string('nama', 100);
            $table->string('warna', 150);
            $table->string('tahun', 5);
            $table->string('transmisi', 100);
            $table->integer('kursi');
            $table->decimal('harga', 12, 2);
            $table->enum('staus', ['tersedia', 'disewakan']);
            $table->string('img');

            $table->softDeletes();
            $table->timestamps();


            $table->foreign('id_kelas')->references('id')->on('kelas');
            $table->foreign('id_brand')->references('id')->on('brands');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
