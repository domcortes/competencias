<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamsDetail extends Model
{
    use HasFactory;

    protected $table = 'teams_detail';

    protected $fillable = [
        'id_usuario',
        'id_equipo',
        'id_competencia',
        'id_categoria',
    ];

    public function competencia(){
        return $this->belongsTo(Competencias::class, 'id_competencia');
    }

    public function categoriaCompetencia(){
        return $this->belongsTo(CategoriasCompetencia::class, 'id_categoria');
    }
}
