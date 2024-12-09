<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profissional;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Mail\AdminNotificationMail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Auth;

class ProfissionalController extends Controller
{
    public function get(){
        $profissionals = Profissional::all();
        return $profissionals;
    }

    public function post(Request $request){

        $profissional = new Profissional([
            'name' => $request->name,
            'cpf' => $request->cpf,
            'endereco' => $request->endereco,
            'telefone' => $request->telefone,
            'tipo' => $request->tipo,
        ]);

        $profissional->save();


        return response()->json('Profissional criado com sucesso', 201);
    }

    public function find($id){
        $p = Profissional::find($id);

        if(!$p)
        {
            return response()->json(['message' => 'Profissional não encontrado.'], 404);
        }

        return response()->json($p, 200);
    }

    public function put(Request $request, $id){

        $p = Profissional::find($id);

        if(!$p)
        {
            return response()->json(['message' => 'Profissional não encontrado.'], 404);
        }

        $p->update([
            'name' => $request->name,
            'cpf' => $request->cpf,
            'endereco' => $request->endereco,
            'telefone' => $request->telefone,
            'tipo' => $request->tipo
        ]);

        return response()->json('Profissional editado com sucesso', 201);
    }

    public function delete($id)
    {
        $p = Profissional::find($id);

        if(!$p)
        {
            return response()->json(['message' => 'Profissional não encontrado.'], 404);
        }

        $p->delete();
        return response()->json('Profissional deletado',201);
    }

    public function index(){
        if (Auth::user()->permission_level == 1) {
            $profissionals = Profissional::all();
            return view('profissionals.listagem', compact('profissionals'));
        }else{
            return redirect()->route('home');
        }
    }

    public function create(){
        if (Auth::user()->permission_level == 1) {
            return view('profissionals.create');
        }else{
            return redirect()->route('home');
        }
    }

    public function store(Request $request){
        // validando os dados de forma basica
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:14',
            'endereco' => 'required|string|max:255',
            'telefone' => 'required|string|max:15',
            'tipo' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        // criando um novo registro na tabela 'profissionals'
        $profissional = new Profissional([
            'name' => $request->name,
            'cpf' => $request->cpf,
            'endereco' => $request->endereco,
            'telefone' => $request->telefone,
            'tipo' => $request->tipo,
        ]);

        $profissional->save();

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'permission_level' => 2, // permissão de profissional
            'profissional_id' => $profissional->id, 
        ]);

        $user->save();

        // redirecionar
        return redirect()->route('profissionals')->with('success', 'Profissional cadastrado com sucesso!');
    }

    public function show($id){
        if (Auth::user()->permission_level == 1) {
            $profissional = Profissional::find($id);
            return view ('profissionals.show', compact('profissional'));
        }else{
                return redirect()->route('home');
            }
    }

    public function destroy($id){
        // encontrar o profissional pelo ID

        $profissional = Profissional::findOrFail($id);
        // deletar o profissional
        $profissional->delete();

        // redirecionar com uma mensagem de sucesso
        return redirect()->route('profissionals')->with('success', 'Profissional deletado com sucesso!');
    }
}
