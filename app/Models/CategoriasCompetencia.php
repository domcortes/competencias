<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriasCompetencia extends Model
{
    use HasFactory;

    public function teamsDetail(){
        return $this->hasMany(TeamsDetail::class, 'id_categoria', 'id');
    }
}
