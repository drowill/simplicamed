<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Consulta;
use App\Models\User;
use App\Models\ProfissionalConsulta;
use App\Http\Requests\ConsultaCreateRequest;
use Illuminate\Support\Facades\Auth;
use App\Mail\AdminNotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
class ConsultaController extends Controller
{
    /*
        Administrador: 2
        Profissional: 1
        Cliente: 0
    */

    public function index()
    {
        if(Auth::user()->permission_level == 2 )
        {
            $consultas = Consulta::with('cliente')->get();
            return response()->json($consultas, 200);
        }
        else if (Auth::user()->permission_level == 1)
        {
            $consultas = []; 
            $profissional_consulta = ProfissionalConsulta::where('profissional_id', '=', Auth::user()->id)->get(); 
            foreach ($profissional_consulta as $pc) {
                 $consulta = Consulta::with('cliente')->find($pc->consulta_id); 
                 if ($consulta) { 
                    $consultas[] = $consulta; 
                } 
            }
            return response()->json([$consultas[0]], 200);

        }

        $consultas = Consulta::where('cliente_id', '=', Auth::user()->id)->get();
        return response()->json($consultas, 200);
    }
    public function store(ConsultaCreateRequest $request)
    {
        $consulta = Consulta::create(array_merge($request->validated(), [
            'cliente_id' => Auth::user()->id,
            'status' => 1
        ]));
        return response($consulta, status: 201);
    }

    public function show($id)
    {
        $pc = ProfissionalConsulta::where('consulta_id', '=', $id)->get();
        if(!empty($pc) && isset($pc[0]))
        {
            $consulta = Consulta::with('cliente')->find($id);
            $consulta->profissional = User::find($pc[0]['profissional_id']);
            if(!$consulta)
            {
                return response()->json(['message' => 'Nenhum consulta encontrada'],404);
            }
            return response($consulta, 200);

        }
        $consulta = Consulta::with('cliente')->find($id);
        return response($consulta, 200);
    }
    public function update(Consulta $request, Consulta $consulta)
    {
    }
    

    public function destroy(Consulta $consulta)
    {
        $consulta->delete();
        return response()->json(['message'=> 'Consulta deletada com sucesso!'],200);
    }

    public function getConsultaById($id)
    {
        $consultas = Consulta::where('cliente_id', '=',$id)->get();

        if(!$consultas)
        {
            return response()->json(['message'=> 'Nenhuma consulta encontrada'],404);

        }
        return response()->json($consultas,status: 200);

    }
   
    public function search($date)
    {
        if(Auth::user()->level_permission === 2 )
        {
            $consultas = Consulta::whereDate($date);
            return response()->json($consultas, 200);
        }else if(Auth::user()->level_permission === 1)
        {
            $consultas = ProfissionalConsulta::where('profissional_id', '=', Auth::user()->id)->get();
            $consultas = Consulta::where('id', $consultas->id)->whereDate($date)->first();    
            return response()->json($consultas, 200);
        }
    
        $consultas = Consulta::where('cliente_id', '=', Auth::user()->id)->whereDate($date)->get();
        return response()->json($consultas, 200);
    }

    public function assignProfessional($id, Request $request)
    {

        $pc = ProfissionalConsulta::where('consulta_id', '=', $id)->get();

        if(!empty($pc) && isset($pc[0]))
        {
            return response()->json(['Essa consulta já possui um profissional associado a ela'], 500);

        }
        if(Auth::user()->permission_level === 2)
        {
            $consulta = Consulta::find($id);
            $cliente = $consulta->cliente_id;
            $profissional = User::find($request->input('profissional'));
    
            $profissional_consulta = ProfissionalConsulta::create([
                'cliente_id' => $cliente,
                'consulta_id' => $consulta->id,  
                'profissional_id' => $profissional->id,
            ]);

            return response()->json([$profissional_consulta], 200);

        }
       
        return response()->json(['Voce não tem permissão para isso'], 419);
    }

    public function confirm($id)
    {
        if(Auth::user()->permission_level == 2)
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
            
            $consulta->status = 2;
            $consulta->save();

            return response()->json(['message'=> 'Consulta confirmada com sucesso'], 200);
        }
        return response()->json(['message' => 'Você não possui as permissões necessárias'], 414);
    }

    public function finalize($id)
    {
        if(Auth::user()->permission_level == 1 || Auth::user()->permission_level == 2)
        {
            $consulta = Consulta::find($id);

            if(!$consulta)
            {
                return response()->json(['message' => 'Nenhuma consulta encontrada'], 404);
            }

            if($consulta->status == 5) 
            {
                return response()->json(['message' => 'Esta consulta já foi finalizada'], 409);
            }
            
            $consulta->status = 5;
            $consulta->save();

            return response()->json(['message'=> 'Consulta confirmada com sucesso'], 200);
        }
        return response()->json(['message' => 'Você não possui as permissões necessárias'], 414);
    }
}
