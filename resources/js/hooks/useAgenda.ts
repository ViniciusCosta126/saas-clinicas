import { useState } from 'react';
import { router } from '@inertiajs/react';
import { AgendaView } from '@/Types/AgendaView';
import { route } from 'ziggy-js';

export function useAgenda(currentData: string, currentView: AgendaView) {
    const [isStoreModalOpen, setIsStoreModalOpen] = useState(false);
    const [selectedSlot, setSelectedSlot] = useState<{ hora: string; data: string } | null>(null);

    const [confirmConfig, setConfirmConfig] = useState({
        isOpen: false,
        title: '',
        message: '',
        routeName: '',
        method: 'put' as 'put' | 'post' | 'delete',
        variant: 'primary' as 'danger' | 'success' | 'primary',
        confirmText: 'Confirmar'
    });

    const [doubleConfirmConfig, setDoubleConfirmConfig] = useState({
        isOpen: false,
        title: '',
        message: '',
        id: null as number | null
    });

    const navigate = (date?: string, view?: AgendaView) => {
        router.get(route('agendamentos.index'), {
            data: date || currentData,
            view: view || currentView
        }, { preserveState: true, preserveScroll: true });
    };

    const triggerAction = (config: Omit<typeof confirmConfig, 'isOpen'>) => {
        setConfirmConfig({ ...config, isOpen: true });
    };

    const closeConfirm = () => setConfirmConfig(prev => ({ ...prev, isOpen: false }));

    const handleConfirm = () => {
        router[confirmConfig.method](confirmConfig.routeName, {}, {
            onSuccess: () => closeConfirm(),
            preserveScroll: true
        });
    };

    const prepararNovo = (hora: string, data: string) => {
        setSelectedSlot({ hora, data });
        setIsStoreModalOpen(true);
    };

    const triggerComparecimento = (id: number, pacienteNome: string) => {
        setDoubleConfirmConfig({
            isOpen: true,
            title: 'Confirmar Comparecimento',
            message: `O paciente ${pacienteNome} compareceu à consulta?`,
            id
        });
    };

    const closeDoubleConfirm = () => setDoubleConfirmConfig(prev => ({ ...prev, isOpen: false }));

    const handleDoubleAction = (type: 'concluir' | 'falta') => {
        if (!doubleConfirmConfig.id) return;

        const url = type === 'concluir'
            ? route('agendamentos.concluir', doubleConfirmConfig.id)
            : route('agendamentos.falta', doubleConfirmConfig.id);

        router.put(url, {}, {
            onSuccess: () => closeDoubleConfirm(),
            preserveScroll: true
        });
    };

    return {
        navigate, 
        prepararNovo,
        isStoreModalOpen, 
        setIsStoreModalOpen, 
        selectedSlot,
        confirmConfig, 
        triggerAction, 
        handleConfirm, 
        closeConfirm, 
        setSelectedSlot, 
        doubleConfirmConfig,
        triggerComparecimento,
        closeDoubleConfirm,
        handleDoubleAction

    };
}