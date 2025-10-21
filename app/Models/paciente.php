<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class paciente extends Model
{
    use HasFactory;
    protected $primaryKey = 'PacienteId';
    protected $fillable = [
        'nombrePaciente',
        'dui',
        'especie',
        'sexo'
    ];
    public $timestamps = false;

    //relacion un paciente puede tener muchos seguimientos
    public function seguimientos(){
        return $this->hasMany(seguimientosUsg::class,'PacienteId');
    }
}
