<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar se o usuário está autenticado e se o nível de permissão é 1
        if (Auth::check() && Auth::user()->permission_level == 1) {
            return $next($request); // Permitir o acesso
        }

        // Redirecionar se o nível de permissão não for 1
        return redirect('/')->with('error', 'Você não tem permissão para acessar esta área.');
    }
}
