<?php

namespace App\Http\Controllers;

use App\Models\CategoriasCompetencia;
use App\Models\FechasCompetencias;
use Illuminate\Http\Request;
use MercadoPago\Item;
use MercadoPago\Preference;
use MercadoPago\SDK;
use Vinkla\Hashids\Facades\Hashids;
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

    public function mercadoPagoObject(Request $request){
        $idCategoria = $request->category;
        $competencia = $request->competition;
        $team_name = $request->team_name;

        if($team_name === null || $idCategoria === null){
            return response()
                ->json([
                    'result' => false,
                    'message' => 'No has seleccionado una categoria o ingresado el nombre de equipo. Completa los datos para continuar'
                ]);
        }

        $categoria = CategoriasCompetencia::where('id', Hashids::decode($idCategoria)[0])->first();

        if($categoria === null){
            return response()
                ->json([
                    'result' => false,
                    'message' => 'No existe una categoria segun los parametros, recarga la pagina e intenta nuevamente.'
                ]);
        }

        $team_name = ($categoria->cantidad_participantes > 1) ? $team_name : auth()->user()->name;

        session(['team_name' => $team_name]);

        SDK::setAccessToken(env('MERCADOPAGO_TOKEN'));
        $preference = new Preference();

        $item = new Item();
        $item->title = 'Inscripción competencia '.$competencia;
        $item->quantity = 1;
        $item->unit_price = $categoria->valor_inscripcion;
        $preference->back_urls = array(
            "success" => route('confirmation.mp.success', [
                Hashids::encode($categoria->id_competencia),
                Hashids::encode(auth()->id()),
                Hashids::encode($categoria->id),
                'true'
            ]),
            "failure" => route('confirmation.mp.failed', [
                Hashids::encode($categoria->id_competencia),
                Hashids::encode(auth()->id()),
                Hashids::encode($categoria->id),
                'false'
            ]),
            "pending" => route('confirmation.mp.pending', [
                Hashids::encode($categoria->id_competencia),
                Hashids::encode(auth()->id()),
                Hashids::encode($categoria->id),
                'pending'
            ])
        );

        $preference->auto_return = "approved";
        $preference->items = [$item];
        $preference->save();

        return response()->json([
            'result' => true,
            'preference_id' => $preference->id,
            'currency' => $categoria->moneda,
            'category_name' => $categoria->nombre_categoria,
            'amount' => $categoria->valor_inscripcion
        ]);
    }
}
