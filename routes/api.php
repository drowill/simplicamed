<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\ProfissionalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfissionalConsultaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/consultas', [ConsultaController::class, 'get']);
Route::post('/consultas', [ConsultaController::class, 'post']);

Route::get('/consultas/{id}', [ConsultaController::class, 'find']);
Route::delete('/consultas/{id}', [ConsultaController::class, 'delete']);
Route::put('/consultas/{id}', [ConsultaController::class, 'put']);


Route::get('/profissionals', [ProfissionalController::class, 'get']);
Route::post('/profissionals', [ProfissionalController::class, 'post']);

Route::get('/profissionals/{id}', [ProfissionalController::class, 'find']);
Route::delete('/profissionals/{id}', [ProfissionalController::class, 'delete']);
Route::put('/profissionals/{id}', [ProfissionalController::class, 'put']);


Route::get('/users', [UserController::class, 'get']);
Route::post('/users', [UserController::class, 'post']);

Route::get('/users/{id}', [UserController::class, 'find']);
Route::delete('/users/{id}', [UserController::class, 'delete']);
Route::put('/users/{id}', [UserController::class, 'put']);


Route::get('/agendamentos', [ProfissionalConsultaController::class, 'get']);
Route::post('/agendamentos', [ProfissionalConsultaController::class, 'post']);

Route::get('/agendamentos/{id}', [ProfissionalConsultaController::class, 'find']);
Route::delete('/agendamentos/{id}', [ProfissionalConsultaController::class, 'delete']);
Route::put('/agendamentos/{id}', [ProfissionalConsultaController::class, 'put']);