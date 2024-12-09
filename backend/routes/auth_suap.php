<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiSuap\AuthenticationSuapController;

Route::post("/gerar-token", [AuthenticationSuapController::class,"generateToken"])->name("generateToken");
