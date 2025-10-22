<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class seguimientosUsg extends Model
{
    use HasFactory;
    protected $primaryKey = 'SeguimientoId';
    protected $fillable = [
        'PacienteId', //id de paciente que se lleva seguimiento
        'solicitud', //MOTIVO DE LA SOLICITUD
        'fechaAlta', // creacion de solicitud
        'fechaSeguimiento', //fecha agendada para usg
        'EstadoProcesoId', // NIVELES DE ESTADO EN PROCESO DEL PACIENTE
        'UsuarioHospital', //ID DEL USUARIO QUE SOLICITA
        'UsuarioUsg', // ID DEL USUARIO QUE REALIZA USG
        'observaciones' //REPORTE ESCRITO DE USG
    ];

    // DEFINIENDO LOS TIPOS DE DATOS PARA LAS FECHAS
    protected $casts = [
        'fechaAlta' => 'datetime',
        'fechaSeguimiento' => 'datetime'
    ];

    public $timestamps = false;

    //relacion el seguimiento pertenece a un paciente
    public function paciente()
    {
        return $this->belongsTo(paciente::class, 'PacienteId');
    }
    //relacion el seguimiento tiene un estado
    public function estado()
    {
        return $this->belongsTo(EstadoProceso::class, 'EstadoProcesoId');
    }
    //relacion el seguimiento fue solicitado por un usuario(HOSPITAL)
    public function usuarioHospital()
    {
        return $this->belongsTo(usuario::class, 'UsuarioHospital');
    }
    //relacion el seguimiento es atendido por un usuario(USG)
    public function usuarioUsg()
    {
        return $this->belongsTo(usuario::class, 'UsuarioUsg');
    }
    //relacion el seguimiento puede tener muchos archivos adjuntos
    public function archivos()
    {
        return $this->hasMany(ArchivoAdjunto::class, 'SeguimientoId');
    }
}
