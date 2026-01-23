<?php

namespace App\Actions\Clinica;

use App\Exceptions\EditarClinicaException;
use App\Models\Clinica;

class EditarClinica
{
    public function execute(int $id, array $dados): Clinica
    {
        $clinica = Clinica::findOrFail($id);
        $this->validaRegrasDeNegocio($clinica, $dados);

        $clinica->update($dados);
        return $clinica;
    }

    private function validaRegrasDeNegocio(Clinica $clinica, array $dados)
    {
        $precoMax = $dados['preco_max_consulta'] ?? $clinica->preco_max_consulta;
        $precoMin = $dados['preco_min_consulta'] ?? $clinica->preco_min_consulta;

        if ((float)$precoMin >= (float)$precoMax) {
            throw new EditarClinicaException(
                'O valor mínimo da consulta não pode ser maior ou igual ao valor máximo.'
            );
        }
    }
}