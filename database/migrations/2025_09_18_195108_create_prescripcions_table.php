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
        Schema::create('prescripcions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('historial_id')->constrained('historial_medicos')->onDelete('cascade'); // si se elimina el historial, se eliminan las prescripciones
            $table->foreignId('medicamento_id')->constrained('medicamentos')->onDelete('restrict'); // no se puede eliminar medicamento si tiene prescripciones
            $table->string('dosis');
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescripcions');
    }
};
