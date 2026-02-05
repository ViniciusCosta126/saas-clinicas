import { AgendaActionConfig } from "@/Types/AgendaAction";
import { IAgendamento } from "@/Types/Agendamento";
import { route } from "ziggy-js";

interface AppointmentCardProps {
    item: IAgendamento;
    isMini?: boolean;
    onAction: (config: AgendaActionConfig) => void;
    onComparecimento: (id: number, pacienteNome: string) => void;
}

export function AppointmentCard({ item, isMini = false, onAction,onComparecimento }: AppointmentCardProps) {
    const trigger = (title: string, message: string, routeName: string, variant: 'danger' | 'success' | 'primary') => {
        onAction({
            title,
            message,
            routeName,
            method: 'put',
            variant
        });
    };

    const containerClass = isMini
        ? `slot-semanal ocupado status-${item.status}`
        : `appointment-card status-${item.status}`;

    return (
        <div className={containerClass}>
            {isMini ? (
                <>
                    <div className="slot-info">
                        <strong>{item.paciente.nome}</strong>
                        <span>{item.horario_inicio}</span>
                    </div>
                    <div className="slot-actions">
                        {item.status !== "nao_compareceu" && item.status !== 'concluido' && (
                            <>
                                <button className="action-mini done" title="Finalizar Atendimento"
                                    onClick={() => onComparecimento(item.id, item.paciente.nome)}>
                                    <i className="fa-solid fa-file-circle-check"></i>
                                </button>
                                <button className="action-mini add" title="Confirmar Presença"
                                    onClick={() => trigger('Confirmar Presença', `O paciente ${item.paciente.nome} chegou?`, route('agendamentos.presenca', item.id), 'success')}>
                                    <i className="fa-solid fa-check"></i>
                                </button>
                                <button className="action-mini delete" title="Cancelar"
                                    onClick={() => trigger('Cancelar Agendamento', 'Tem certeza que deseja cancelar?', route('agendamentos.cancelar', item.id), 'danger')}>
                                    <i className="fa-solid fa-xmark"></i>
                                </button>
                            </>
                        )}
                    </div>
                </>
            ) : (
                <>
                    <div className="patient-avatar">{item.paciente.nome.charAt(0).toUpperCase()}</div>
                    <div className="patient-details">
                        <strong>{item.paciente.nome}</strong>
                        <span><i className="fa-regular fa-clock"></i> {item.horario_inicio} - {item.horario_fim}</span>
                    </div>
                    <div className="table-actions">
                        {item.status !== "nao_compareceu" && item.status !== 'concluido' && (
                            <>
                                <button className="btn-action done" title="Finalizar Atendimento"
                                    onClick={() => onComparecimento(item.id, item.paciente.nome)}>
                                    <i className="fa-solid fa-file-circle-check"></i>
                                </button>
                                <button className="btn-action add" title="Confirmar"
                                    onClick={() => trigger('Presença', 'Confirmar chegada do paciente?', route('agendamentos.presenca', item.id), 'success')}>
                                    <i className="fa-solid fa-check" />
                                </button>
                                <button className="btn-action delete" title="Cancelar"
                                    onClick={() => trigger('Cancelar', 'Deseja cancelar este agendamento?', route('agendamentos.cancelar', item.id), 'danger')}>
                                    <i className="fa-solid fa-xmark"></i>
                                </button>
                            </>
                        )}
                    </div>
                </>
            )}
        </div>
    );
}