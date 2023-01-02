<?php

namespace App\Http\Controllers;

use App\Models\FechasCompetencias;
use Illuminate\Http\Request;
use Vinkla\Hashids\HashidsManager;

class FechasCompetenciasController extends Controller
{
    protected $hashids;

    public function __construct(HashidsManager $hashids){
        $this->hashids = $hashids;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $fecha = new FechasCompetencias;
            $fecha->id_competencia = $this->hashids->decode($request->competition)[0];
            $fecha->fecha = $request->start;
            $fecha->hora = $request->time;
            $fecha->modalidad = $request->modalidad;
            $fecha->publicado = true;
            $fecha->descripcion = $request->description;
            $fecha->save();

            return redirect()
                ->route('competencias.show', $request->competition)
                ->with('success', 'Fecha creada exitosamente.');
        } catch (\Illuminate\Database\QueryException $exception){
            $errorInfo = $exception->errorInfo;
            return redirect()
                ->route('competencias.show', $request->competition)
                ->with('error', $errorInfo[2]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    static public function show($id)
    {
        return FechasCompetencias::where('id_competencia', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param int $id
     * @return int
     *
     */
    static public function contadorFechas($id){
        $fechas = FechasCompetencias::where('id_competencia', $id)->get();
        return count($fechas);
    }
}
