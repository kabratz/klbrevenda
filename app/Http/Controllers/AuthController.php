<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Valida os dados recebidos
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tenta autenticar o usuário
        if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
            // Recupera o usuário autenticado
            $user = Auth::user();

            // Retorna a resposta com o usuário autenticado
            return response()->json([
                'success' => true,
                'user' => $user,
            ]);
        } else {
            // Retorna uma resposta de erro se a autenticação falhar
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials.',
            ], 401); // Código de status HTTP 401 para "Unauthorized"
        }
    }

}
