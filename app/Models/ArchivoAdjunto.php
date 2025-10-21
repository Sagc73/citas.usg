<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArchivoAdjunto extends Model
{
    use HasFactory;
    protected $primaryKey = 'ArchivoId';
    protected $fillable = [
        'SeguimientoId',
        'nombreArchivo',
        'rutaArchivo',
        'tipoArchivo',
        'fechaCarga'
    ];
    protected $casts = ['fechaCarga' => 'datatime'];
    public $timestamps = false;

    //relacion un archivo pertenece a un seguimiento
    public function seguimiento(){
        return $this->belongsTo(seguimientosUsg::class,'SeguimientoId');
    }
}
