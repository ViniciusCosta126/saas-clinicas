import { format, startOfWeek, addDays, isSameDay, parseISO, isBefore } from 'date-fns';
import { ptBR } from 'date-fns/locale';
import { AppointmentCard } from './AppointmentCard';
import { IAgendamento } from '@/Types/Agendamento';


interface WeeklyViewProps{
    horarios:string[]
    agendamentos:IAgendamento[]
    dataSelecionada:string;
    onNew: (hora: string, data: string) => void;
    onAction: (config: any) => void;
    onComparecimento: (id: number, nome: string) => void;
}
export function WeeklyView({ horarios, agendamentos, dataSelecionada, onNew,onAction,onComparecimento }:WeeklyViewProps) {
    const start = startOfWeek(parseISO(dataSelecionada), { weekStartsOn: 1 });
    const days = Array.from({ length: 7 }, (_, i) => addDays(start, i));
    return (
        <div className="semana-grid">
            <div className="time-col">
                {horarios.map(h => <span key={h}>{h}</span>)}
            </div>
            
            {days.map(day => (
                <div className="dia-coluna" key={day.toISOString()}>
                    <div className={`col-header ${isSameDay(day, new Date()) ? 'hoje' : ''}`}>
                        <span className="dia-nome">{format(day, 'eee', { locale: ptBR })}</span>
                        <span className="dia-data">{format(day, 'dd/MM')}</span>
                    </div>

                    {horarios.map(hora => {
                        const agend = agendamentos.find(a => 
                            isSameDay(parseISO(a.data), day) && a.horario_inicio === hora
                        );
                        const isPast = isBefore(parseISO(`${format(day, 'yyyy-MM-dd')}T${hora}`), new Date());

                        return agend ? (
                            <AppointmentCard key={hora} item={agend} isMini onAction={onAction} onComparecimento={onComparecimento}/>
                        ) : (
                            <div 
                                key={hora}
                                className={`slot-semanal ${isPast ? 'bloqueado' : 'disponivel'}`}
                                onClick={() => !isPast && onNew(hora, format(day, 'yyyy-MM-dd'))}
                            >
                                <i className={`fa-solid ${isPast ? 'fa-ban' : 'fa-plus'}`} />
                            </div>
                        );
                    })}
                </div>
            ))}
        </div>
    );
}