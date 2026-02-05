import { useEffect } from 'react';
import { useForm, usePage } from '@inertiajs/react';
import Modal from '@/components/common/ui/Modal/Modal';
import FormTemplate from '@/components/common/FormTemplate';
import InputGroup from '@/components/common/ui/Formulario/InputGroup';
import { route } from 'ziggy-js';
import { IPaciente } from '@/Types/Paciente';
import { IPageProps } from '@/Types/PageProps';
import { IProfissional } from '@/Types/Profissional';
import { addHours, format, parse } from 'date-fns';

interface Props {
    isOpen: boolean;
    onClose: () => void;
    initialData: { hora: string; data: string } | null;
    pacientes: IPaciente[];
    profissionais: IProfissional[]
}

export default function StoreAgendamentoModal({ isOpen, onClose, initialData, pacientes, profissionais }: Props) {
    const { auth } = usePage<IPageProps>().props
    const { data, setData, post, processing, errors, reset } = useForm({
        paciente_id: '',
        data: '',
        horario_inicio: '',
        horario_fim: '',
        clinica_id: auth.clinica?.id,
        profissional_id: '',
        status: 'agendado'
    });

    useEffect(() => {
        if (isOpen && initialData) {
            setData({
                ...data,
                data: initialData.data,
                horario_inicio: initialData.hora,
            });
        }
    }, [isOpen, initialData]);

    useEffect(() => {
        if (data.horario_inicio) {
            const baseDate = new Date();
            const startTime = parse(data.horario_inicio, 'HH:mm', baseDate);

            const endTime = addHours(startTime, 1);

            setData('horario_fim', format(endTime, 'HH:mm'));
        }
    }, [data.horario_inicio]);

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('agendamentos.store'), {
            onSuccess: () => {
                reset();
                onClose();
            },
        });
    };

    return (
        <Modal
            isOpen={isOpen}
            title="Novo Agendamento"
            onClose={onClose}
        >
            <FormTemplate onSubmit={handleSubmit} className="invite-form">
                <div className="form-grid">

                    <InputGroup label="Paciente" icon="fa-hospital-user" error={errors.paciente_id} fullWidth>
                        <select
                            value={data.paciente_id}
                            onChange={e => setData('paciente_id', e.target.value)}
                            required
                        >
                            <option value="">Selecione um paciente...</option>
                            {pacientes.map(p => (
                                <option key={p.id} value={p.id}>{p.nome}</option>
                            ))}
                        </select>
                    </InputGroup>

                    <InputGroup label="Profissional" icon="fa-hospital-user" error={errors.profissional_id} fullWidth>
                        <select
                            value={data.profissional_id}
                            onChange={e => setData('profissional_id', e.target.value)}
                            required
                        >
                            <option value="">Selecione um profissional...</option>
                            {profissionais.map(p => (
                                <option key={p.id} value={p.id}>{p.nome}</option>
                            ))}
                        </select>
                    </InputGroup>

                    <InputGroup label="Data" icon="fa-calendar" error={errors.data} fullWidth>
                        <input
                            type="date"
                            value={data.data}
                            onChange={e => setData('data', e.target.value)}
                        />
                    </InputGroup>

                    <InputGroup label="Horário de Início" icon="fa-clock" error={errors.horario_inicio}>
                        <input
                            type="time"
                            step="3600"
                            value={data.horario_inicio}
                            onChange={e => {
                                const val = e.target.value;
                                if (!val) return setData('horario_inicio', '');

                                const [hora] = val.split(':');
                                const horaCheia = `${hora}:00`;

                                setData('horario_inicio', horaCheia);
                            }}
                        />
                    </InputGroup>

                    <InputGroup label="Horário de Término" icon="fa-clock" error={errors.horario_fim}>
                        <input
                            readOnly
                            type="time"
                            value={data.horario_fim}
                            step={'1:00'}
                            onChange={e => setData('horario_fim', e.target.value)}
                        />
                    </InputGroup>

                </div>

                <div className="form-actions">
                    <button type="button" className="btn-cancel" onClick={onClose}>
                        Cancelar
                    </button>
                    <button type="submit" className="btn-submit" disabled={processing}>
                        <i className="fa-solid fa-check"></i>
                        {processing ? 'Agendando...' : 'Confirmar Agendamento'}
                    </button>
                </div>
            </FormTemplate>
        </Modal>
    );
}