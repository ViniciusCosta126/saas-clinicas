<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Profissional;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $profissionais = Profissional::all()->count();
        $pacientes = Paciente::visiveis()->get()->count();
        return view('dashboard.index',compact('profissionais','pacientes'));
    }
}
