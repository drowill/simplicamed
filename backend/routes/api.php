<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ConsultaController;
use App\Http\Controllers\Api\ProfissionalController;
use App\Http\Controllers\Api\ConsultaProfissionalController;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('consultas', ConsultaController::class)->except('getConsultaById', 'assignProfessional');
Route::get('/minhas-consultas/{id}', [ConsultaController::class, 'getConsultaById'])->name('consulta-by-id');
Route::resource('profissionais', ProfissionalController::class)->except('update');
Route::patch('/profissionais/{id}', [ProfissionalController::class, 'update']);
Route::get('/consulta/accepted/{id}', [ConsultaProfissionalController::class,'accepted'])->name('accepted');
Route::get('/consulta/rejected/{id}', [ConsultaProfissionalController::class,'rejected'])->name('rejected');
Route::post('confirmar_consulta/{id}', [ConsultaController::class,'confirm'])->name('confirmar-consulta');
Route::post('finalizar_consulta/{id}', [ConsultaController::class,'finalize'])->name('finalizar-consulta');
Route::get('consultas/{data}', [ConsultaController::class, 'getConsultasByDate']);
Route::post('consultas/{id}/associar-profissional', [ConsultaController::class, 'assignProfessional']);
