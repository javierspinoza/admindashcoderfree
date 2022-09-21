<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barrio extends Model
{
    use HasFactory;

    protected $table = 'barrios';
    protected $fillable = [
        'id',
        'name',
        'ciudad_id',
    ];
    // public $timestamps=false;

    public function ciudades() {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    public function direcciones() {
        return $this->hasMany(Direccion::class, 'id');
    }
}
