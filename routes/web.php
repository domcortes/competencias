<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $competencias = \App\Models\Competencias::where('pagado', true)->get();
    return view('welcome', compact('competencias'));
})->name('main');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('competencias', \App\Http\Controllers\CompetenciasController::class);

Route::resource('fechas', \App\Http\Controllers\FechasCompetenciasController::class);

Route::resource('categorias', \App\Http\Controllers\CategoriasCompetenciaController::class);

Route::group(['prefix' => 'ajax'], function(){
    Route::post('publish', [\App\Http\Controllers\AjaxController::class, 'publishSwitch'])->name('ajax.publish');
    Route::post('mercado_pago', [\App\Http\Controllers\AjaxController::class, 'mercadoPagoObject'])->name('ajax.mercado_pago');
});

Route::group(['prefix' => 'atletas'], function(){
    Route::get('register', [\App\Http\Controllers\AtletasController::class, 'index'])->name('atletas.register');
    Route::post('registrar', [\App\Http\Controllers\AtletasController::class, 'create'])->name('atletas.create');
    Route::get('inscribir/{id_competencia}',[\App\Http\Controllers\AtletasController::class, 'inscription'])->name('atletas.inscripcion');
    Route::get('mis-competencias-registradas',[\App\Http\Controllers\AtletasController::class, 'misCompetencias'])->name('atletas.competencias_registradas');
});

Route::resource('competencias-atletas',\App\Http\Controllers\CompetenciasAtletas::class);

Route::group(['prefix' => 'payment'], function(){
    Route::group(['mp'], function(){
        Route::get('success/{id_competencia}/{id_atleta}/{id_categoria}/{status}',[\App\Http\Controllers\PagosController::class, 'MercadoPagoPayment'])->name('confirmation.mp.success');
        Route::get('failed/{id_competencia}/{id_atleta}/{id_categoria}/{status}',[\App\Http\Controllers\PagosController::class, 'MercadoPagoPayment'])->name('confirmation.mp.failed');
        Route::get('pending/{id_competencia}/{id_atleta}/{id_categoria}/{status}',[\App\Http\Controllers\PagosController::class, 'MercadoPagoPayment'])->name('confirmation.mp.pending');
    });
});


