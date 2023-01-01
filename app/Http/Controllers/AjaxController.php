<?php

namespace App\Http\Controllers;

use App\Models\CategoriasCompetencia;
use App\Models\FechasCompetencias;
use Illuminate\Http\Request;
use Vinkla\Hashids\HashidsManager;

class AjaxController extends Controller
{
    protected $hashids;

    public function __construct(HashidsManager $hashids){
        $this->hashids = $hashids;
        $this->middleware('auth');
    }

    public function publishSwitch(Request $request){

        $item = $request->item;
        $line = $this->hashids->decode($request->line)[0];
        $status = (boolean) $request->switch;

        switch ($item){
            case 'categorias':
                try {
                    $categoria = CategoriasCompetencia::find($line);
                    $categoria->publicado = $status;
                    $categoria->save();

                    $retorno = $this->jsonResponse(true, ucfirst($item).' actualizada/o correctamente');
                } catch (\Illuminate\Database\QueryException $exception){
                    $errorInfo = $exception->errorInfo;
                    $retorno = $this->jsonResponse(false, 'Error: '.$errorInfo[2]);
                }
                break;

            case 'fechas':
                try {
                    $fecha = FechasCompetencias::find($line);
                    $fecha->publicado = $status;
                    $fecha->save();

                    $retorno = $this->jsonResponse(true, ucfirst($item).' actualizada/o correctamente');
                } catch (\Illuminate\Database\QueryException $exception){
                    $errorInfo = $exception->errorInfo;
                    $retorno = $this->jsonResponse(false, 'Error: '.$errorInfo[2]);
                }
                break;
        }

        return $retorno;
    }

    public function jsonResponse($result, $message)
    {
        return response()
            ->json([
                'result' => $result,
                'message' => $message,
            ]);
    }
}
