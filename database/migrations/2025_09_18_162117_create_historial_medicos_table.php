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
        Schema::create('historial_medicos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cita_id')->nullable()->constrained('citas')->nullOnDelete();

            $table->foreignId('paciente_id')->constrained('pacientes')->cascadeOnDelete();

            $table->longText('diagnostico');
            $table->longText('tratamiento')->nullable();
            $table->longText('observaciones_paciente')->nullable();

            $table->string('archivo_path')->nullable();
            $table->string('archivo_nombre_original')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_medicos');
    }
};
