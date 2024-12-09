<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

Route::get('/', [DashboardController::class,'home'])->name('home');

Route::get('/user', [UserController::class, 'getUser'])->name('user.logado');


/*
    Rotas de autentificação da api do backend;
*/
require __DIR__.'/auth.php';
/*
    Rotas de autentificação do suap
*/
require __DIR__ .'/auth_suap.php';
/*
    Rotas de autentificação do google
*/
require __DIR__ .'/auth_google.php';

