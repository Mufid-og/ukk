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
        Schema::create('transaksies', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_car');
            $table->date('tanggal');
            $table->date('telepon');
            $table->integer('durasi_sewa');
            $table->decimal('total', 12,2);
            $table->enum('status', ['disewakan', 'pending', 'selesai'])->default('pending');
            $table->string('atas_nama', 150);
            $table->string('bukti_img')->nullable();

            $table->timestamps();

            $table->foreign('id_car')->references('id')->on('cars');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksies');
    }
};
