<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class seguimientosUsg extends Model
{
    public function paciente(){
        return $this->belongsTo(paciente::class,'PacienteId');
    }
    public function estado(){
        return $this->belongsTo(estado::class, 'EstadoProcesoId');
    }
    public function usuarioHospital(){
        return $this->belongsTo(usuario::class, 'UsuarioHospital');
    }
    public function usuarioUsg(){
        return $this->belongsTo(usuario::class,'UsuarioUsg');
    }
    public function archivos(){
        return $this->hasMany(ArchivoAdjunto::class,'SeguimientoId');
    }
}
