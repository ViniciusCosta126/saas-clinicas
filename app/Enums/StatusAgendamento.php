<?php

namespace App\Enums;


enum StatusAgendamento: string
{
    case AGENDADO = 'agendado';
    case CONFIRMADO = 'confirmado';
    case CONCLUIDO = 'concluido';
    case CANCELADO = 'cancelado';
    case NAO_COMPARECEU = 'nao_compareceu';

    public function label(): string
    {
        return match ($this) {
            self::AGENDADO => "Agendado",
            self::CONFIRMADO => 'Confirmado',
            self::CONCLUIDO => 'concluido',
            self::CANCELADO => 'Cancelado',
            self::NAO_COMPARECEU => 'Não compareceu',
        };
    }

}