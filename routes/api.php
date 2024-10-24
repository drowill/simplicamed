<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultaController;

Route::apiResource('consultas', ConsultaController::class);