import { IPaciente } from "./Paciente";

export interface IAgendamento {
    id: number,
    clinica_id: number,
    profissional_id: number,
    paciente: IPaciente,
    data: string,
    horario_inicio: string,
    horario_fim: string,
    status: 'agendado' | 'confirmado' | 'concluido' | 'cancelado' | 'nao_compareceu',
}