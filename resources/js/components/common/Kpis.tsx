import React from "react";

interface KpisProps {
    profissionais: number,
    pacientes: number,
    agendamentos: number
}

export default function Kpis({ profissionais, pacientes, agendamentos }: KpisProps) {
    return (
        <div className="kpi-row">
            <div className="kpi-card">{pacientes} Pacientes</div>
            <div className="kpi-card">
                {agendamentos > 1 ? `${agendamentos} Consultas Hoje.` : 'Sem consultas Hoje'}
            </div>
            <div className="kpi-card">R$ 24.580</div>
            <div className="kpi-card">{profissionais} {profissionais > 1 ? 'Profissionais' : 'Profissional'}</div>
        </div>
    )
}