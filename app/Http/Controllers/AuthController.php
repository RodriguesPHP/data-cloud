<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        // Tentar autenticar o usuário
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            // Se a autenticação for bem-sucedida, redirecionar com uma mensagem de sucesso
            return redirect()->intended('dashboard')->with('success', 'Login realizado com sucesso!');
        }

        // Se a autenticação falhar, redirecionar de volta com uma mensagem de erro
        return redirect()->back()
            ->withInput($request->only('email'))
            ->with('error', 'Credenciais inválidas.');
    }

    public function logout(){
        Auth::logout();
        return redirect()->intended('login');
    }
}
