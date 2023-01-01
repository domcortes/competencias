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
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('competencias', \App\Http\Controllers\CompetenciasController::class);

Route::resource('fechas', \App\Http\Controllers\FechasCompetenciasController::class);

Route::resource('categorias', \App\Http\Controllers\CategoriasCompetenciaController::class);

Route::group(['prefix' => 'ajax'], function(){
    Route::post('publish', [\App\Http\Controllers\AjaxController::class, 'publishSwitch'])->name('ajax.publish');
});
