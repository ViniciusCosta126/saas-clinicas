<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use App\Models\User;
use App\Models\UserInvites;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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
            return back()->withErrors(['email' => 'Credenciais inválidas']);
        }

        if (!auth()->user()->clinica_id) {
            Auth::logout();
            return back()->withErrors(['email' => 'Usuário sem clínica vinculada']);
        }

        return redirect('/dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function criarContaConvite(string $token)
    {
        $convite = UserInvites::where('token', $token)->first();

        if (!$convite) {
            abort(404, 'Convite inválido.');
        }

        if ($convite->used_at) {
            return redirect()->route('login')
                ->with('error', 'Este convite já foi utilizado.');
        }

        if (Carbon::now()->greaterThan($convite->expires_at)) {
            return redirect()->route('login')
                ->with('error', 'Este convite expirou.');
        }

        return view('paginas.convite-criar-conta.index', compact('convite'));
    }

    public function postCriarContaConvite(Request $request, UserInvites $convite)
    {
        if ($convite->used_at) {
            return redirect('/login')->withErrors('Este convite já foi utilizado.');
        }

        if (now()->greaterThan($convite->expires_at)) {
            return redirect('/login')->withErrors('Este convite expirou.');
        }

        DB::transaction(function () use ($request, $convite, &$usuario) {

            $usuario = User::create([
                'name' => $convite->nome,
                'email' => $convite->email,
                'password' => Hash::make($request->senha),
                'telefone' => $request->telefone,
                'cpf' => $request->cpf,
                'clinica_id' => $convite->clinica_id
            ]);

            $convite->update([
                'used_at' => now()
            ]);
        });

        Auth::login($usuario);

        return redirect('/dashboard');
    }
}
