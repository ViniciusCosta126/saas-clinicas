import FormTemplate from "@/components/common/FormTemplate";
import InputGroup from "@/components/common/ui/Formulario/InputGroup";
import Modal from "@/components/common/ui/Modal/Modal";
import { IProfissional } from "@/Types/Profissional";
import { IUser } from "@/Types/User";
import { useForm } from "@inertiajs/react";
import { FormEvent, ReactEventHandler, useEffect, useState } from "react";
import { route } from "ziggy-js";

interface ProfissionalProps {
    isOpen: boolean;
    onClose: () => void
    profissional?: IProfissional | null,
    usuarios: IUser[]
}

export default function ProfissionalModal({ profissional, isOpen, onClose, usuarios }: ProfissionalProps) {
    const { data, put, post, errors, processing, setData } = useForm({
        nome: profissional?.nome || '',
        email: profissional?.email || '',
        especialidade: profissional?.especialidade || '',
        preco_sessao: profissional?.preco_sessao || '',
        user_id: profissional?.user_id || '',
        clinica_id: profissional?.clinica_id || '',
    })

    const handleSelectChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        const selectedId = e.target.value;
        const usuarioSelecionado = usuarios.find(user => String(user.id) === selectedId);

        setData({
            ...data,
            email:usuarioSelecionado?.email,
            user_id: selectedId,
            clinica_id: usuarioSelecionado?.clinica_id || '',
            nome: usuarioSelecionado?.name || ''
        });
    }

    useEffect(() => {
        if (profissional) {
            setData({
                nome: profissional.nome || '',
                email: profissional.email || '',
                especialidade: profissional.especialidade || '',
                preco_sessao: profissional.preco_sessao || '',
                clinica_id: profissional.clinica_id || '',
                user_id: profissional.user_id || ''
            });
        } else {
            setData({
                nome: '',
                email: '',
                especialidade: '',
                preco_sessao: '',
                clinica_id: '',
                user_id: ''
            });
        }
    }, [profissional, isOpen]);

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault()
        if (profissional) {
            put(route('profissionais.update', profissional.id), { onSuccess: () => onClose() })
        } else {
            post(route('profissionais.store'), {
                onSuccess: () => {
                    setData({
                        nome: '',
                        email: '',
                        especialidade: '',
                        preco_sessao: '',
                        clinica_id: '',
                        user_id: ''
                    })
                    onClose()
                },
            })
        }
    }
    return (
        <Modal title={profissional ? 'Editar Profissional' : 'Criar um novo profissional'} isOpen={isOpen} onClose={onClose}>
            <FormTemplate onSubmit={(e)=>handleSubmit(e)} className="form-profissional">
                <div className="form-grid">
                    {
                        profissional ? '' : (
                            <InputGroup fullWidth icon="fa-user" error={errors.user_id} label="Nome completo">
                                <select value={data.user_id} name="" id="" onChange={handleSelectChange}>
                                    <option value="" disabled> Selecione um usuario</option>
                                    {usuarios.map(user => (
                                        <option key={user.id} value={user.id}>{user.name}</option>
                                    ))}
                                </select>
                            </InputGroup>
                        )
                    }

                    <InputGroup fullWidth={false} error={errors.especialidade} label="Especialidade do medico" icon="fa-user">
                        <input type="text" value={data.especialidade} onChange={(e) => setData('especialidade', e.target.value)} placeholder="Terapia corportamental" />
                    </InputGroup>


                    <InputGroup fullWidth={false} error={errors.preco_sessao} label="Preço da sessão" icon="fa-dollar">
                        <input type="number" step={0.01} value={data.preco_sessao} onChange={(e) => setData('preco_sessao', e.target.value)} placeholder="50.00" />
                    </InputGroup>
                </div>

                <div className="form-actions">
                    <button type="submit" className="btn-submit" disabled={processing}>
                        <i className={`fa-solid ${profissional ? 'fa-check' : 'fa-paper-plane'}`}></i>
                        {profissional ? ' Salvar Alterações' : ' Enviar Convite'}
                    </button>
                </div>
            </FormTemplate>
        </Modal>
    )
}