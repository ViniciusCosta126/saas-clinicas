<?php

namespace App\Helpers;

use App\Models\Clinica;

class ClinicaHelper{
    public static function getNomeClinica($id){
        $clinica = Clinica::where('id',$id)->pluck("nome_clinica")->first();

        if($clinica){
            return $clinica;
        }

        return "Sem nome";
    }
}