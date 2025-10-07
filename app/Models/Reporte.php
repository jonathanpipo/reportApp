<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reporte extends Model
{

    use HasFactory;

    protected $fillable = [
        'categoria',
        'avaliacaoInfraestrutura',
        'latitude',
        'longitude',
        'precisao',
        'descricao',
    ];

}
