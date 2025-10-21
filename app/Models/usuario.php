<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usuario extends Model
{
    public function rol(){
        return $this->belongsTo(rol::class,'RolId');
    }
}
