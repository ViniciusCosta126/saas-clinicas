<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfissional;
use App\Models\Profissional;
use App\Models\User;
use Illuminate\Http\Request;

class ProfissionaisController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        $profissionais = Profissional::paginate(10);
        return view('dashboard.profissionais.index', compact('profissionais', 'usuarios'));
    }

    public function store(StoreProfissional $request)
    {
        $dados = $request->validated();
        $profissional = Profissional::create($dados);
        return to_route("profissionais.index");
    }

    public function delete(Profissional $profissional)
    {
        $profissional->delete();
        return to_route("profissionais.index");
    }
}
