<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller{
    public function create() {
        return view('auth.register');
    }

    public function store (Request $request) {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed', 
        ]);
    
        // Retornar erros de validação
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Criptografar a senha
        $hashedPassword = Hash::make($request->password);
    
        // Criar o usuário no banco de dados
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $hashedPassword,
        ]);

        // logar após o registro
        // Auth::login($user);
    
        // Retornar uma mensagem de sucesso
        return redirect()->route('home')->with('success', 'Usuário cadastrado com sucesso!');
    }
}
