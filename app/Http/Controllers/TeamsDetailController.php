<?php

namespace App\Http\Controllers;

use App\Models\CategoriasCompetencia;
use App\Models\Teams;
use Illuminate\Http\Request;

class TeamsDetailController extends Controller
{
    static public function getTeamName($equipo){
        $equipo = Teams::findOrFail($equipo);
        $categoria = CategoriasCompetencia::findOrFail($equipo->id_categoria);
        ($categoria->cantidad_participantes === 1) ? $teamName = 'No aplica nombre de equipo' : $teamName = ucwords($equipo->team_name);
        return $teamName;
    }
}
