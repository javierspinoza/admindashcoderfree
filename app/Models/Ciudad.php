<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;

    protected $table = 'ciudades';
    protected $fillable = [
        'id',
        'name',
        'departamento_id',
    ];
    // public $timestamps=false;

    public function departamentos() {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function barrios() {
        return $this->hasMany(Barrio::class, 'id');
    }

    public function direcciones() {
        return $this->hasMany(Direccion::class, 'id');
    }
}
