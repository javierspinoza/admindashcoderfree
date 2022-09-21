<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horarios';
    protected $fillable = [
        'id',
        'nombre',
        'id_materia',
    ];
    // public $timestamps=false;

    public function materias() {
        return $this->belongsTo(Materia::class, 'id_materia');
    }
}
