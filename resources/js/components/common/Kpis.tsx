import { formatToBRL } from "@/utils/format";

interface KpisProps {
    profissionais: number,
    pacientes: number,
    agendamentos: number,
    faturamento: number
    comparativoMensal: {
        atual: number,
        anterior: number,
        variacao: number
    }
}

export default function Kpis({ profissionais, pacientes, agendamentos, faturamento, comparativoMensal }: KpisProps) {
    return (
        <div className="kpi-row">
            <div className="kpi-card">{pacientes > 0 ? `${pacientes} Pacientes` : 'Sem pacientes'}</div>
            <div className="kpi-card">
                {agendamentos > 0 ? `${agendamentos} Consulta(s) Hoje.` : 'Sem consultas Hoje'}
            </div>
            <div className="kpi-card">{formatToBRL(faturamento)}</div>
            <div className="kpi-card"> {profissionais > 0 ? `${profissionais} Profissional(is)` : 'Sem profissionais'}</div>
            <div className="kpi-compare">
                <span className="label">Faturamento do mês</span>

                <span className="value">
                    {formatToBRL(comparativoMensal.atual)}
                </span>

                <span className={`variation ${comparativoMensal.variacao >= 0 ? 'up' : 'down'}`}>
                    {comparativoMensal.variacao >= 0 ? '↑' : '↓'} {comparativoMensal.variacao}%
                    <span className="hint">vs mês anterior</span>
                </span>
            </div>
        </div>
    )
}