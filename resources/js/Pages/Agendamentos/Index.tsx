
import { useAgenda } from '@/hooks/useAgenda';
import CardContainer from '@/components/common/CardContainer';
import PageHeader from '@/components/common/PageHeader';
import { DailyView } from './DailyView';
import { WeeklyView } from './WeeklyView';
import StoreAgendamentoModal from './StoreAgendamentoModal';

import { IPaciente } from '@/Types/Paciente';
import { IAgendamento } from '@/Types/Agendamento';
import { AgendaView } from '@/Types/AgendaView';
import { IProfissional } from '@/Types/Profissional';

import '../../../css/dashboard/agendamento/index.scss';
import DashboardLayout from '@/Layouts/DashboardLayout';
import ConfirmActionModal from './ConfirmActionModal';
import ComparecimentoModal from './ComparecimentoModal';

interface AgendamentoProps {
    agendamentos: IAgendamento[];
    dataSelecionada: string;
    view: AgendaView;
    horarios: string[];
    pacientes: IPaciente[];
    profissionais: IProfissional[];
}

export default function Index({ agendamentos, dataSelecionada, view, horarios, pacientes, profissionais }: AgendamentoProps) {
    const {
        navigate, prepararNovo, isStoreModalOpen, setIsStoreModalOpen, selectedSlot,
        confirmConfig, triggerAction, handleConfirm, closeConfirm, setSelectedSlot, doubleConfirmConfig, closeDoubleConfirm, handleDoubleAction, triggerComparecimento
    } = useAgenda(dataSelecionada, view);

    return (
        <DashboardLayout>
            <PageHeader titulo='Agendamentos' subtitulo='Gerencie seus horários de forma simples.' />

            <CardContainer>
                <div className="page-header-actions" style={{ display: 'flex', alignItems: 'center', marginBottom: '20px' }}>
                    <button className="btn-primary" onClick={() => { setSelectedSlot(null); setIsStoreModalOpen(true); }}>
                        <i className="fa-solid fa-plus"></i> Novo Agendamento
                    </button>

                    <div className="date-picker-wrapper">
                        <i className="fa-solid fa-calendar-day"></i>
                        <input
                            type="date"
                            value={dataSelecionada}
                            onChange={(e) => navigate(e.target.value)}
                        />
                    </div>

                    <div className="view-switcher">
                        <button
                            className={`btn-view ${view === 'diario' ? 'active' : ''}`}
                            onClick={() => navigate(undefined, 'diario')}
                        >Dia</button>
                        <button
                            className={`btn-view ${view === 'semanal' ? 'active' : ''}`}
                            onClick={() => navigate(undefined, 'semanal')}
                        >Semana</button>
                    </div>
                </div>

                <div className="agenda-body">
                    {view === 'diario' ? (
                        <DailyView
                            horarios={horarios}
                            agendamentos={agendamentos}
                            dataSelecionada={dataSelecionada}
                            onNew={prepararNovo}
                            onAction={triggerAction}
                            onComparecimento={triggerComparecimento}
                        />
                    ) : (
                        <WeeklyView
                            horarios={horarios}
                            agendamentos={agendamentos}
                            dataSelecionada={dataSelecionada}
                            onNew={prepararNovo}
                            onAction={triggerAction}
                            onComparecimento={triggerComparecimento}
                        />
                    )}
                </div>
            </CardContainer>

            <StoreAgendamentoModal
                isOpen={isStoreModalOpen}
                onClose={() => setIsStoreModalOpen(false)}
                initialData={selectedSlot}
                pacientes={pacientes}
                profissionais={profissionais}
            />

            <ConfirmActionModal
                isOpen={confirmConfig.isOpen}
                title={confirmConfig.title}
                message={confirmConfig.message}
                variant={confirmConfig.variant}
                confirmText={confirmConfig.confirmText}
                onClose={closeConfirm}
                onConfirm={handleConfirm}
            />

            <ComparecimentoModal
                isOpen={doubleConfirmConfig.isOpen}
                title={doubleConfirmConfig.title}
                message={doubleConfirmConfig.message}
                onClose={closeDoubleConfirm}
                onAction={handleDoubleAction}
            />
        </DashboardLayout>
    );
}