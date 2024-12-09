<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\ProfissionalCreateRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfissionalUpdateRequest;


class ProfissionalController extends Controller
{
    /*
        Administrador: 2
        Profissional: 1
        Cliente: 0
    */

    /**
     * @OA\Get(
     *     path="/profissionais",
     *     summary="List all profissionais",
     *     @OA\Response(
     *         response=200,
     *         description="A list of profissionais"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index()
    {
        $profissionais = User::where('permission_level', '=', 1)->get();
        return response()->json([
            'profissionais' => $profissionais
        ]);
    }

   
    public function store(ProfissionalCreateRequest $request)
    {
        $profissional = User::create(array_merge($request->validated(), [
            'permission_level' => 1
        ]));
        return response()->json(['profissional' => $profissional], 201);
    }
    public function show($id)
    {
        $profissional = User::find($id);
        if(!$profissional)
        {
            return response()->json(['message' => 'Nenhum profissional encontrado', 404]);
        }
        return response()->json([
            'profissional' => $profissional,
            'id' => $id
        ], 200);
    }

    public function destroy($id)
    {
        $profissional = User::find($id);
        if(!$profissional)
        {
            return response()->json(['message' => 'Nenhum profissional encontrado', 404]);
        }
        $profissional->delete();
        return response()->json(['profissional'=> $profissional], 200);
    }

    
    public function update(ProfissionalUpdateRequest $request, $id)
    {
        $profissional = User::find($id);
        if(!$profissional)
        {
            return response()->json(['message'=> 'Profissional não encontrado', 404]);
        }
        $profissional->update(array_merge($request->validated(), [
            'permission_level' => Auth::user()->permission_level,
        ]));
        return response()->json([$profissional], 200);
    }
}
