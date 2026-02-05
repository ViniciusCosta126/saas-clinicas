import { format, parseISO, isBefore, isToday } from 'date-fns';
import { AppointmentCard } from './AppointmentCard';
import { IAgendamento } from '@/Types/Agendamento';

interface DailyViewProps {
    horarios: string[];
    agendamentos: IAgendamento[];
    dataSelecionada: string;
    onNew: (hora: string, data: string) => void;
    onAction: (config: any) => void;
    onComparecimento: (id: number, nome: string) => void;
}

export const DailyView = ({ horarios, agendamentos, dataSelecionada, onNew, onAction,onComparecimento }: DailyViewProps) => {
    const checkIfDisabled = (hora: string) => {
        const [hours, minutes] = hora.split(':');
        const slotDate = parseISO(dataSelecionada);
        slotDate.setHours(parseInt(hours), parseInt(minutes), 0);
        const agora = new Date();
        return isBefore(slotDate, agora);
    };

    return (
        <div className="daily-calendar-wrapper">
            {horarios.map((hora) => {
                const item = agendamentos.find(a => a.horario_inicio === hora);
                const isPast = checkIfDisabled(hora);

                return (
                    <div className="agenda-row" key={hora}>
                        <div className="time-marker">
                            <span>{hora}</span>
                        </div>

                        <div className="appointment-slot">
                            {item ? (
                                <AppointmentCard item={item} onAction={onAction} onComparecimento={onComparecimento}/>
                            ) : (
                                <div
                                    className={`empty-slot ${isPast ? 'disabled' : ''}`}
                                    onClick={() => !isPast && onNew(hora, dataSelecionada)}
                                >
                                    {isPast ? (
                                        <>
                                            <i className="fa-solid fa-ban"></i>
                                            <span>Horário encerrado</span>
                                        </>
                                    ) : (
                                        <>
                                            <i className="fa-solid fa-plus-circle"></i>
                                            <span>Disponível para agendamento</span>
                                        </>
                                    )}
                                </div>
                            )}
                        </div>
                    </div>
                );
            })}
        </div>
    );
};