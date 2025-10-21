<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable as NotificationsNotifiable;
use Iluminate\Notifications\Notifiable;

class usuario extends Authenticatable
{
  use HasFactory;
  use NotificationsNotifiable;

  protected $primaryKey = 'usuarioId';
  protected $fillable = [
    'nombreUsuario',
    'email',
    'password',
    'RolId'
  ];

  protected $hidden = [
    'password',
    'remember_token'
  ];

  public $timestamps = false;

  //RELACION UN USUARIO PERTENECE A UN ROL
  public function rol(){
    return $this->belongsTo(rol::class,'RolId');
  }

  //RELACION UN USUARIO(HOSPITAL) PUEDE CREAR MUCHOS SEGUIMIENTOS
  public function seguimientosCreados(){
    return $this->hasMany(seguimientosUsg::class,'UsuarioHospital');
  }

  //relacion un usuario (USG) puede atender muchos seguimientos
  public function seguimientosAtendidos(){
    return $this->hasMany(seguimientosUsg::class,'UsuariosUsg');
  }
}
