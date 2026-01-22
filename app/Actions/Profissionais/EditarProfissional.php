<?php

namespace App\Actions\Profissionais;

use App\Exceptions\EditarProfissionalException;
use App\Models\Profissional;

class EditarProfissional
{
    public function execute(int $id, array $dados): Profissional
    {
        $profissional = Profissional::findOrFail($id);

        $this->validaRegrasDeNegocio($dados, $profissional);

        $profissional->update([
            'preco_sessao' => $dados['preco_sessao'],
            'especialidade' => $dados['especialidade']
        ]);
        
        return $profissional;
    }

    private function validaRegrasDeNegocio(array $dados, Profissional $profissional)
    {
        if ($profissional->clinica_id !== auth()->user()->clinica_id) {
            throw new EditarProfissionalException("Você não tem acesso para editar este profisisonal");
        }

        if ($dados['preco_sessao'] > $profissional->clinica->preco_maximo_sessao) {
            throw new EditarProfissionalException(
                'O valor da sessão ultrapassa o limite permitido pela clínica.'
            );
        }

        if ($dados['preco_sessao'] < $profissional->clinica->preco_minimo_sessao) {
            throw new EditarProfissionalException(
                'O valor da sessão é menor que o minimo autorizado pela clinica.'
            );
        }
    }
}