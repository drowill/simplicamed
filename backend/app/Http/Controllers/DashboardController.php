<?php

namespace App\Http\Controllers;

use App\Models\User;
class DashboardController extends Controller
{
    /*
        Administrador: 2
        Profissional: 1
        Cliente: 0
    */
    public function home()
    {
        $profissionais = User::where('permission_level', '=', 1)->get();
        return response()->json([ 
            'profissionais' => $profissionais 
        ]);
    }
}
