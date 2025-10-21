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
        Schema::create('archivo_adjuntos', function (Blueprint $table) {
            $table->id('ArchivoId');
            $table->foreignId('SeguimientoId')->constrained('seguimientos_usgs','SeguimientoId');
            $table->string('nombreArchivo');
            $table->text('rutaArchivo');
            $table->string('tipoArchivo');
            $table->timestamp('fechaCarga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivo_adjuntos');
    }
};
