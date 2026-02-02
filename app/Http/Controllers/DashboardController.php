<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Paciente;
use App\Models\Profissional;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $profissionais = Profissional::all()->count();
        $pacientes = Paciente::visiveis()->get()->count();
        $agendamentos = Agendamento::doDia(Carbon::today()->format('Y-m-d'))->ativos()->count();

        return Inertia::render('Dashboard');
        return view('dashboard.index', compact('profissionais', 'pacientes', 'agendamentos'));
    }
}
