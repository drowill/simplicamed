<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ClienteCreateRequest;
class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(ClienteCreateRequest $request)
    {
      
      
        $user = User::create(array_merge($request->validated(), [ 
            'password' => Hash::make($request->password), 
            'permission_level' => 0, 
        ])); 

        event(new Registered($user));

        Auth::login($user);

        return response()->json([$user, 'Usuário registrado com sucesso!'], 200);
    }
}
