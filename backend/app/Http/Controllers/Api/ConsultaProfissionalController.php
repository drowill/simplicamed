<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfissionalConsulta;
use App\Models\Consulta;
use Illuminate\Support\Facades\Auth;


class ConsultaProfissionalController extends Controller
{
    /*
        Pendente: 1
        Confirmado: 2,
        Rejeitado: 3,
        Cancelado: 4,
        Finalizado: 5
    */

    public function rejected($id)
    {
        if(Auth::user()->permission_level == 1)
        {
            $consulta = Consulta::find($id);

            if(!$consulta)
            {
                return response()->json(['message' => 'Nenhuma consulta encontrada'], 404);
            }

            $profissional_consulta = ProfissionalConsulta::where('consulta_id', '=', $consulta->id)
            ->where('cliente_id', '=', $consulta->cliente_id)
            ->first();

            if($profissional_consulta)
            {
                $consulta->status = 3;
                $consulta->save();

                return response()->json(['message'=> 'Consulta rejeitada pelo usuário'], 200);
            }
            return response()->json([
                'message'=> 'Você não pode modificar essa consulta',
                'info' => $profissional_consulta,
            ], 500);
        }
        return response()->json(['message' => 'Você não possui as permissões necessárias'], 414);
    }

    public function accepted($id)
    {
        if(Auth::user()->permission_level == 1)
        {
            $consulta = Consulta::find($id);

            if(!$consulta)
            {
                return response()->json(['message' => 'Nenhuma consulta encontrada'], 404);
            }

            if($consulta->status != 1) 
            {
                return response()->json(['message' => 'Esta consulta já foi processada por outro profissional'], 409);
            }

            $profissional_consulta = ProfissionalConsulta::where('consulta_id', '=', $consulta->id)
                                                         ->where('cliente_id', '=', $consulta->cliente_id)
                                                         ->first();

            if($profissional_consulta)
            {
                $consulta->status = 2;
                $consulta->save();

                return response()->json(['message'=> 'Consulta aceita com sucesso'], 200);
            }
            return response()->json([
                'message'=> 'Você não pode modificar essa consulta',
                'info' => $profissional_consulta,
            ], 500);
        }
        return response()->json(['message' => 'Você não possui as permissões necessárias'], 414);
    }
}
