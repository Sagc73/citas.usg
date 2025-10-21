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
        Schema::create('seguimientos_usgs', function (Blueprint $table) {
            $table->id('SeguimientoId');
            $table->foreignId('PacienteId')->constrained('pacientes','PacienteId');
            $table->text('solicitud');
            $table->date('fechaAlta');
            $table->date('fechaSeguimiento')->nullable();
            $table->foreignId('EstadoProcesoId')->constrained('estado_procesos','EstadoProcesoId');
            $table->foreignId('UsuarioHospital')->constrained('usuarios','usuarioId');
            $table->foreignId('UsuarioUsg')->constrained('usuarios','usuarioId');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguimientos_usgs');
    }
};
