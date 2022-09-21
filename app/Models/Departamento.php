<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departamentos';
    protected $fillable = [
        'id',
        'name',
    ];
    // public $timestamps=false;

    public function ciudades() {
        return $this->hasMany(Ciudad::class, 'id');
    }

    public function direcciones() {
        return $this->hasMany(Direccion::class, 'id');
    }
}
