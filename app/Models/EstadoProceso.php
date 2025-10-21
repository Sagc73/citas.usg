<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstadoProceso extends Model
{
    use HasFactory;
    protected $primaryKey = 'EstadoProcesoId';
    protected $fillable = ['nombreEstado'];
    public $timestamps = false;

    //relacion un estado pertenece a muchos seguimientos
    public function seguimientos(){
        return $this->hasMany(seguimientosUsg::class,'EstadoProcesoId');
    }
}
