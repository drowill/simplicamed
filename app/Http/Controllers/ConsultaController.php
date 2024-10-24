<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;

class ConsultaController extends Controller
{
    public function index()
    {
        $consultas = Consulta::all();
        return $consultas;
    }

    public function store(Request $request)
    {
        $nome= $request->input('nome');
        $idade= $request->input('idade');
        $data= $request->input('data');
        $peso= $request->input('peso');
        $c = Consulta::create([
            'nome' => $nome,
            'idade' => $idade,
            'data' => $data,
            'peso' => $peso
        ]);
        $id = $c->id;
        return response(
            [
                'location' => route('consultas.show', $id)],
                201
            );
    }

    public function show(Consulta $consulta)
    {
        return $consulta;
    }

    public function destroy(Consulta $consulta)
    {
        $consulta->delete();
    }

    public function update(Request $request, Consulta $consulta)
    {
        $nome = $request->input('nome');
        if ($nome)
            $consulta->nome = $nome;
        $idade = $request->input('idade');
        if ($idade)
            $consulta->idade = $idade;
        $data = $request->input('data');
        if ($data)
            $consulta->data = $data;
        $peso = $request->input('peso');
        if ($peso)
            $consulta->peso = $peso;
        $consulta->save();
    } 
}
