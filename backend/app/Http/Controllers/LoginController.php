<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller {
    public function create() {
        return view('auth.login');
    }

    public function store (Request $request) {
         // Validação das credenciais de login
         $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Se a validação falhar, retorna com os erros
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Tentativa de autenticação
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Se a autenticação for bem-sucedida, cria a sessão
            $request->session()->regenerate();

            // Redireciona para a home após logar
            return redirect()->intended('home')->with('success', 'Login realizado com sucesso!');
        }

        // Se as credenciais estiverem incorretas, retorna com erro
        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Desloga o usuário
        Auth::logout();

        // Invalida a sessão
        $request->session()->invalidate();

        // Gera um novo token CSRF
        $request->session()->regenerateToken();
        
        // Redireciona para a página de login
        return redirect()->route('login')->with('success', 'Você foi deslogado com sucesso!');
    }
}
