<?php
namespace App\Http\Controllers\ApiGoogle;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
class GoogleController extends Controller
{
    public function googleLogin()
    {
        $redirectUrl = Socialite::driver("google")->redirect()->getTargetUrl(); 
        return response()->json(['url' => $redirectUrl], 200);
    }

    public function googleAuthentication()
    {
        $googleUser = Socialite::driver('google')->user();
        $user = User::where('google_id', $googleUser->id)->first();
        if($user)
        {
            Auth::login($user);
            return redirect("http://localhost:3000/home");
            // return response()->json(['message' => 'Logado com google'],200);
        }
        else {
            $userData = User::create([
                'name' => $googleUser->name,
                'email'=> $googleUser->email,
                'password'=> Hash::make($googleUser->password),
                'google_id' => $googleUser->id,
            ]);
            if ($userData)
            {
                Auth::login($userData);
                return redirect("http://localhost:3000/home");
            }
            else 
            {
                return response()->json(['message' => 'Não foi possível logar com o Google'],200);
            }
        }
    }
}
