<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ClienteUpdateRequest;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getUser()
    {
        $user = Auth::user();
        if(!$user)
        {
            return response()->json(['message' => 'Usuário não está logado, reinicie a sessão'], 500);

        }
        return response()->json($user, 200);
    }



}
