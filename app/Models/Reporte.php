<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reporte extends Model
{
    use HasFactory;

    protected $table = 'reportes';

    protected $fillable = [
        'categoria_id',
        'avaliacao',
        'latitude',
        'longitude',
        'comentario',
        'ativo',
        'data_expiracao',
    ];

    /**
     * Relacionamento: um reporte pertence a uma categoria.
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
