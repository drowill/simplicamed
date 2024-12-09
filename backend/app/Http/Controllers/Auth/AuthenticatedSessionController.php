<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json(['token' => $request->session()->token()]);
        }

        return response()->json(['error' => 'As credenciais fornecidas não correspondem aos nossos registros.'], 401);
    }

    public function destroy(Request $request)
    {
        
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['success' => 'Você foi deslogado com sucesso!']);
    }
}
