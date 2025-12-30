<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'descricao',
    ];

    public $timestamps = false; // pois a migration não tem timestamps()

    /**
     * Relacionamento: uma categoria possui muitos reportes.
     */
    public function reportes()
    {
        return $this->hasMany(Reporte::class, 'categoria_id');
    }
}