<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class rol extends Model
{
    use HasFactory;
    protected $primaryKey = 'RolId';
    protected $fillable = ['nombreRol'];
    public $timestamps = false;

    //RELACION UN ROL PUEDE TENER MUCHOS USUARIOS
    public function usuarios(){
        return $this->hasMany(usuario::class,'RolId');
    }
}
