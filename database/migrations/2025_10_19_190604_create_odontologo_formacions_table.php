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
        Schema::create('odontologo_formacions', function (Blueprint $table) {
            $table->id();

              // Relación con odontologo
            $table->unsignedBigInteger('odontologo_id');
            $table->foreign('odontologo_id')->references('id')->on('odontologos')->onDelete('cascade');

            $table->string('archivo'); // nombre del PDF
            $table->string('descripcion')->nullable(); // opcional, título o descripción del documento

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odontologo_formacions');
    }
};
