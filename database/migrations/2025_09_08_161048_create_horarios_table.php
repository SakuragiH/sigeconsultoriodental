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
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();

           // Relación con odontólogos
            $table->foreignId('odontologo_id')->constrained('odontologos')->onDelete('cascade');

            // Día de la semana (solo referencia, se puede calcular desde la fecha)
            $table->enum('dia', ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo']);

            // Fecha específica del horario
            $table->date('fecha');

            // Horarios de atención
            $table->time('hora_inicio');
            $table->time('hora_fin');

            // Estado del horario: true = disponible, false = bloqueado
            $table->boolean('disponible')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
