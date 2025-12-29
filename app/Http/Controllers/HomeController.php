<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function indexLogin()
    {
        return view('paginas.login.index');
    }

    public function criarConta()
    {
        return view('paginas.criar-conta.index');
    }

    public function postCriarConta(Request $request)
    {
        $resposta = $this->authService->criarConta($request->all());

        if (Auth::user()) {
            return redirect('/dashboard');
        }

        return to_route('criar-conta');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->only('email', 'senha');

        if (!Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['senha']])) {
            dd("teste");
            return back()->withErrors(['email' => 'Credenciais inválidas']);
        }

        if (!auth()->user()->clinica_id) {
            Auth::logout();
            return back()->withErrors(['email' => 'Usuário sem clínica vinculada']);
        }

        return redirect('/dashboard');
    }
}
