<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Consulta; //CHAMAMOS O MODEL DA NOSSA CONSULTA
use App\Models\Profissional; //CHAMAMOS O MODEL Do nosso profissional
use App\Models\ProfissionalConsulta;
use Illuminate\Support\Facades\Auth;

use App\Mail\AdminNotificationMail;
use App\Mail\ConsultaCancelada;
use App\Mail\ConsultaRejeitada;
use Illuminate\Support\Facades\Mail;


class ConsultaController extends Controller
{
    public function get() {
        $consultas = Consulta::all();
        return $consultas;
    } 

    public function post(Request $request){
        $title= $request->input('title');
        $user_id= $request->input('user_id');
        $idade= $request->input('idade');
        $descricao= $request->input('descricao');
        $data= $request->input('data');
        $horario= $request->input('horario');
        $status= $request->input('status');
        $c = Consulta::create([
            'title' => $title,
            'user_id' => $user_id,
            'idade' => $idade,
            'descricao' => $descricao,
            'data' => $data,
            'horario' => $horario,
            'status' => $status
        ]);
        $id = $c->id;
        return response()->json('Consulta criada com sucesso', 201);
    }

    public function put(Request $request, $id){

        $consulta = Consulta::find($id);

        $consulta->update([
            'title' => $request->input('title'),
            'user_id' => $request->input('user_id'),
            'idade' => $request->input('idade'),
            'descricao' => $request->input('descricao'),
            'data' => $request->data,
            'horario' => $request->input('horario'),
            'status' => $request->input('status')
        ]);

        return response()->json('Consulta editada com sucesso', 201);
    }

    public function find($id){
        $c = Consulta::find($id);

        if(!$c)
        {
            return response()->json(['message' => 'Consulta não encontrada.'], 404);
        }

        return response()->json($c, 200);
    }

    public function delete($id)
    {
        $c = Consulta::find($id);

        if(!$c)
        {
            return response()->json(['message' => 'Consulta não encontrada.'], 404);
        }

        $c->delete();
        return response()->json('Consulta deletada',201);
    }

    public function index(){
        // Verifica se o usuário é admin
        if (Auth::user()->permission_level == 1) {
            // Pegar todas as consultas para admin
            $consultas = Consulta::whereDate('data', now())
            ->orderBy('status')
            ->with('user')->get();
        }else if (Auth::user()->permission_level == 0){
            // Pegar apenas as consultas do usuário normal
            $consultas = Consulta::whereDate('data', now())
                ->where('user_id', Auth::id())
                ->orderBy('status') // Adiciona a condição para pegar apenas as consultas do usuário logado
                ->with('user')->get();
        } 
        // else if (Auth::user()->permission_level == null) {
        //     $consultas = Consulta::all();
        //     return $consultas;
        // }
        else{
            // Lista as consultas associadas ao profissional
            $consultas = Consulta::whereDate('data', now())
            ->whereHas('profissionalConsulta', function ($query) {
                // Usa diretamente o profissional_id do usuário autenticado
                $query->where('profissional_id', Auth::user()->profissional_id);
            })
            ->orderBy('status') // Ordenar por status
            ->with('user') // Carregar relação com o usuário
            ->get();
        }

        return view('welcome', compact('consultas'));
    }

    public function minhasConsultas(Request $request) {
        // Captura o parametro de busca
        $search = $request->input('search');

        if (Auth::user()->permission_level == 1) {
            // Lista todas as consultas de todos os usuários
            $query = Consulta::query();
        } else if (Auth::user()->permission_level == 0) {
            // Lista as consultas do usuário logado
            $query = Consulta::where('user_id', Auth::id());
        } else {
            // Lista as consultas associadas ao profissional
            $query = Consulta::whereHas('profissionalConsulta', function ($query) {
                $query->where('profissional_id', Auth::user()->profissional_id);
            });
        }

        // Aplica a lógica de busca (se houver parametro)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                ->orWhere('descricao', 'like', "%$search%")
                ->orWhere('horario', 'like', "%$search%");
            });
        }

        // Obtenha os resultados
        $consultas = $query->orderBy('data', 'desc')->get();

        return view('profile', compact('consultas'));
    }

    public function getConsultasByDate($date){
        // Verifica se o usuário é admin
        if (Auth::user()->permission_level == 1) {
            // Busca todas as consultas para admin
            $consultas = Consulta::whereDate('data', $date)->with('user')->get();
        } else if(Auth::user()->permission_level == 1){
            // Busca apenas as consultas do usuário normal
            $consultas = Consulta::whereDate('data', $date)
                ->where('user_id', Auth::id()) // Adiciona a condição para pegar apenas as consultas do usuário logado
                ->with('user')->get();
        }else{
            $consultas = Consulta::whereDate('data', $date)
            ->whereHas('profissionalConsulta', function ($query) {
                // Usa diretamente o profissional_id do usuário autenticado
                $query->where('profissional_id', Auth::user()->profissional_id);
            })
            ->orderBy('status') // Ordenar por status
            ->with('user') // Carregar relação com o usuário
            ->get();
        }

        // Verificar se a coleção está vazia
        if ($consultas->isEmpty()) {
            return response()->json(['html' => '<p>Nenhuma consulta encontrada para essa data.</p>']);
        }

        // Renderizar a lista de consultas
        $view = view('consultas-list', compact('consultas'))->render();
        return response()->json(['html' => $view]);
    }

    public function create() {
        return view('consulta.consultas');
    }

    public function store(Request $request){
        // validando os dados de forma basica
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'idade' => 'required|integer|min:0',
            'descricao' => 'required|string',
            'data' => 'required|date',
            'horario' => 'required',
        ]);

        // criando um novo registro na tabela 'consultas'
        $consulta = new Consulta([
            'title' => $validatedData['title'],
            'user_id' => Auth::user()->id,
            'idade' => $validatedData['idade'],
            'descricao' => $validatedData['descricao'],
            'data' => $validatedData['data'],
            'horario' => $validatedData['horario'],
            'status' => 1,
        ]);

        // salvando a consulta no banco de dados
        $consulta->save();

        // Enviar e-mail para o admin
        Mail::to('emily.nogueira@escolar.ifrn.edu.br')->send(new AdminNotificationMail($consulta));
        
        // redirecionar
        return redirect()->route('consultas')->with('success', 'Agendamento realizado com sucesso!');
    }

    public function show($id){
        // Buscar a consulta pelo ID
        $consulta = Consulta::with(['user', 'profissionalConsulta.profissional'])->findOrFail($id); // Lança um erro 404 se não encontrar
        $profissionais = Profissional::all(); // Lança um erro 404 se não encontrar

        // Retorna a view com a consulta
        return view('consulta.show', compact('consulta', 'profissionais'));
    }

    public function edit($id){
        // Buscar a consulta pelo ID
        $consulta = Consulta::with('user')->findOrFail($id);

        // Retorna a view de edição com a consulta
        return view('consulta.edit', compact('consulta'));
    }

    public function update(Request $request, $id){
        // Validação dos dados
        $request->validate([
            'title' => 'required|string|max:255',
            'idade' => 'required|integer|min:0',
            'endereco' => 'required|string|max:255',
            'descricao' => 'required|string',
            'data' => 'required|date',
        ]);

        // Atualiza a consulta
        $consulta = Consulta::findOrFail($id);
        $consulta->update($request->all());
        // Redireciona com uma mensagem de sucesso
        return redirect()->route('consultas')->with('success', 'Consulta atualizada com sucesso!');
    }

    public function cancelar($id){
        // Buscar a consulta pelo ID
        $consulta = Consulta::findOrFail($id);
        
        // Atualizar o status para 4 (Cancelado)
        $consulta->status = 4;
        $consulta->save();

        // Enviar email para o admin
        Mail::to('emily.nogueira@escolar.ifrn.edu.br')->send(new ConsultaCancelada($consulta));

        // Redirecionar com uma mensagem de sucesso
        return redirect()->back()->with('success', 'Consulta cancelada com sucesso!');
    }

    public function rejeitar($id) {
        // Encontrar a consulta pelo ID
        $consulta = Consulta::findOrFail($id);
    
        // Atualizar o status para "Rejeitado"
        $consulta->status = 3; // 3 para "Rejeitado"
        $consulta->save();

        // Buscar a associação de consulta e profissional pelo ID
        $profissionalConsulta = ProfissionalConsulta::findOrFail($id);

        // Atualizar o status para "Rejeitado"
        $profissionalConsulta->status = 3; // 3 para "Rejeitado"
        $profissionalConsulta->save();
        
        Mail::to($consulta->user->email)->send(new ConsultaRejeitada($consulta));
        Mail::to('emily.nogueira@escolar.ifrn.edu.br')->send(new ConsultaRejeitada($consulta));
    
        return redirect()->back()->with('success', 'Consulta rejeitada com sucesso.');
    }

    public function usuario_ausente($id) {
        // Encontrar a consulta pelo ID
        $consulta = Consulta::findOrFail($id);
    
        // Atualizar o status para "usuario ausente"
        $consulta->status = 6; // 6 para "usuario ausente"
        $consulta->save();

        // Buscar a associação de consulta e profissional pelo ID
        $profissionalConsulta = ProfissionalConsulta::findOrFail($id);

        // Atualizar o status para "usuario ausente"
        $profissionalConsulta->status = 6; // 6 para "usuario ausente"
        $profissionalConsulta->save();
    
        return redirect()->back()->with('success', 'Consulta ausentada com sucesso');
    }

}
