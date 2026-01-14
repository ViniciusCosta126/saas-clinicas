<?php

namespace App\Http\Controllers;

use App\Models\Profissional;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $profissionais = Profissional::all()->count();
        return view('dashboard.index',compact('profissionais'));
    }
}
