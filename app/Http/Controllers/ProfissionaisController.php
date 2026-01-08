<?php

namespace App\Http\Controllers;

use App\Models\Profissional;
use Illuminate\Http\Request;

class ProfissionaisController extends Controller
{
    public function index()
    {
        $profissionais = Profissional::paginate(10);
        return view('dashboard.profissionais.index', compact('profissionais'));
    }
}
