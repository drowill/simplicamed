<?php

namespace App\Http\Controllers\ApiSuap;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class AuthenticationSuapController extends Controller
{
    public function generateToken(Request $request)
    {
        $client = new Client();
        try {
            $response = $client->post('https://suap.ifrn.edu.br/api/v2/autenticacao/token/', [ 
                'params' => [ 
                    'username' => 'aaa', 
                    'password' => 'password', 
                ] 
            ]);
            return response()->json([$client], 200);

            $token = $response->getBody()->getContents();
            return response()->json([$token], 200);
        }catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao obter o token'], 500);
        }
    }

    public function verifyToken(Request $request)
    {
    }
}
