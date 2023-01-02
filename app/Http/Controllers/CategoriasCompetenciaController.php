<?php

namespace App\Http\Controllers;

use App\Models\CategoriasCompetencia;
use Illuminate\Http\Request;
use Vinkla\Hashids\HashidsManager;

class CategoriasCompetenciaController extends Controller
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
            $categoria = new CategoriasCompetencia;
            $categoria->id_competencia = $this->hashids->decode($request->competition)[0];
            $categoria->nombre_categoria = $request->category;
            $categoria->cantidad_participantes = $request->quantity;
            $categoria->save();

            return redirect()
                ->route('competencias.show', $request->competition)
                ->with('success', 'Categoría creada exitosamente.');
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
        return CategoriasCompetencia::where('id_competencia', $id)->get();
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
