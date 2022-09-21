<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;

    protected $table = 'direcciones';
    protected $fillable = [
        'id',
        'name',
        'departamento_id',
        'ciudad_id',
        'barrio_id',
    ];

    public function departamentos() {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function ciudades() {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    public function barrios() {
        return $this->belongsTo(Barrio::class, 'barrio_id');
    }
}
