<?php

namespace App\Actions\Profissionais;

use App\Exceptions\CriarProfissionalException;
use App\Models\Profissional;

class CriarProfissional
{

    public function execute(array $dados): Profissional
    {
        $this->validaRegrasDeNegocio($dados);
        return Profissional::create($dados);
    }

    private function validaRegrasDeNegocio(array $dados)
    {
        if ($dados['clinica_id'] != auth()->user()->clinica_id) {
            throw new CriarProfissionalException(message: "Você não tem permissão para criar este profissional.");
        }

        $clinica = auth()->user()->clinica;

        if ($dados['preco_sessao'] > $clinica->preco_max_consulta) {
            throw new CriarProfissionalException(
                'O valor da sessão ultrapassa o limite permitido pela clínica.'
            );
        }

        if ($dados['preco_sessao'] < $clinica->preco_min_consulta) {
            throw new CriarProfissionalException(
                'O valor da sessão é menor que o minimo autorizado pela clinica.'
            );
        }
    }
}