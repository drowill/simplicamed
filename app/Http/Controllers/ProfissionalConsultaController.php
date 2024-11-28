<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Mail\ConsultaCadastradaMail;
use App\Mail\ConsultaFinalizadaMail;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use App\Models\Consulta;
use App\Models\Profissional;
use App\Models\ProfissionalConsulta;


class ProfissionalConsultaController extends Controller
{

    public function get() {
        $agendas = ProfissionalConsulta::all();
        return $agendas;
    }

    public function post(Request $request){

        $agenda = new ProfissionalConsulta([
            'user_id' => $request->user_id,
            'profissional_id' => $request->profissional_id,
            'consulta_id' => $request->consulta_id,
            'status' => $request->status,
        ]);

        $agenda->save();


        return response()->json('Agendamento criado com sucesso', 201);
    }

    public function put(Request $request, $id){

        $a = ProfissionalConsulta::find($id);

        if(!$a)
        {
            return response()->json(['message' => 'Agendamento não encontrado.'], 404);
        }

        $a->update([
            'user_id' => $request->user_id,
            'profissional_id' => $request->profissional_id,
            'consulta_id' => $request->consulta_id,
            'status' => $request->status,
        ]);

        return response()->json('Agendamento editado com sucesso', 201);
    }

    public function delete($id)
    {
        $a = ProfissionalConsulta::find($id);

        if(!$a)
        {
            return response()->json(['message' => 'Agendamento não encontrado.'], 404);
        }

        $a->delete();
        return response()->json('Agendamento deletado',201);
    }

    public function find($id){
        $a = ProfissionalConsulta::find($id);

        if(!$a)
        {
            return response()->json(['message' => 'Agendamento não encontrado.'], 404);
        }

        return response()->json($a, 200);
    }

    public function store(Request $request){
        // Validação dos dados enviados
        $request->validate([
            'consulta_id' => 'required|exists:consultas,id',
            'profissional_id' => 'required|exists:profissionals,id',
        ]);

        // Salvar a associação no banco de dados
        ProfissionalConsulta::create([
            'user_id' => $request->user_id, 
            'consulta_id' => $request->consulta_id,
            'profissional_id' => $request->profissional_id,
            'status' => 1, // status pendendte
        ]);

        return redirect()->back()->with('success', 'Profissional associado com sucesso!');
    }

    public function confirmarConsulta($id){
        // Buscar a associação de consulta e profissional pelo ID
        $profissionalConsulta = ProfissionalConsulta::findOrFail($id);

        $consulta = Consulta::find($profissionalConsulta->consulta_id);

        // Atualizar o status para 2 (Confirmado)
        $consulta->status = 2;
        $consulta->save();

        // Atualizar o status para 2 (Confirmado)
        $profissionalConsulta->status = 2;
        $profissionalConsulta->save();

        Mail::to($consulta->user->email)->send(new ConsultaCadastradaMail($consulta));
        Mail::to('emily.nogueira@escolar.ifrn.edu.br')->send(new ConsultaCadastradaMail($consulta));
        
        // Redirecionar com uma mensagem de sucesso
        return redirect()->back()->with('success', 'Consulta confirmada com sucesso!');
    }

    public function finalizar($id){
        // Buscar a consulta e a relação com o profissional
        $profissionalConsulta = ProfissionalConsulta::where('consulta_id', $id)->firstOrFail();
        $consulta = Consulta::find($profissionalConsulta->consulta_id);

        // Alterar o status para 5 (Finalizado)
        $profissionalConsulta->status = 5;
        $profissionalConsulta->save();
        $consulta->status = 5;
        $consulta->save();
        // Após mudar o status para 5 (Finalizado)
        Mail::to($consulta->user->email)->send(new ConsultaFinalizadaMail($consulta));
    
        return redirect()->back()->with('success', 'Consulta finalizada com sucesso!');
    }
}
