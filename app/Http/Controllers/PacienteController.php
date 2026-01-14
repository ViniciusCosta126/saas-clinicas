<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index(){
        $pacientes = Paciente::paginate(10);
        return view('dashboard.pacientes.index',compact('pacientes'));
    }
}
