<?php

namespace App\Http\Controllers;

use App\Models\Competencias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\HashidsManager;

class CompetenciasController extends Controller
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
        $competencias = Competencias::where('created_by', Auth::user()->id)
            ->get();

        return view('competencias.index', compact('competencias'));
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
            $competencia = new Competencias;
            $competencia->nombre_competencia = $request->name;
            $competencia->fecha_inicio = $request->start;
            $competencia->fecha_termino = $request->end;
            $competencia->valor_pago = 100;
            $competencia->created_by = Auth::id();
            $competencia->updated_by = Auth::id();
            $competencia->save();

            return redirect()->route('competencias.index')->with('success', 'Competencia creada exitosamente.');
        } catch (\Illuminate\Database\QueryException $exception){
            $errorInfo = $exception->errorInfo;
            return redirect()->route('recaudadores.lista')->with('error', $errorInfo[2]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $competencia = $this->hashids->decode($id)[0];
        $fechas = FechasCompetenciasController::show($competencia);
        return view('competencias.show', compact('fechas'));
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
}
