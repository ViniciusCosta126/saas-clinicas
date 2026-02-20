import FormTemplate from "@/components/common/FormTemplate";
import InputGroup from "@/components/common/ui/Formulario/InputGroup";
import Modal from "@/components/common/ui/Modal/Modal";
import { IPaciente } from "@/Types/Paciente";
import { IPageProps } from "@/Types/PageProps";
import { IProfissional } from "@/Types/Profissional";
import { useForm, usePage } from "@inertiajs/react";
import { FormEvent, useEffect } from "react";
import { route } from "ziggy-js";


interface PacienteProps {
    isOpen: boolean;
    onClose: () => void
    paciente?: IPaciente | null,
    profissionais:IProfissional[]
}

export default function PacienteModal({ isOpen, onClose, paciente,profissionais }: PacienteProps) {
    const { auth } = usePage<IPageProps>().props
    const permissions: string[] = auth?.permissions ?? [];
    const can = (permission: string) => permissions.includes(permission);

    const { put, post, setData, data, errors, processing } = useForm({
        nome: paciente?.nome,
        email: paciente?.email,
        aniversario: paciente?.aniversario,
        telefone: paciente?.telefone,
        clinica_id: paciente?.clinica?.id ?? auth.clinica?.id
    })

    useEffect(() => {
        if (paciente) {
            setData({
                nome: paciente.nome || '',
                email: paciente.email || '',
                aniversario: paciente.aniversario || '',
                telefone: paciente.telefone || '',
                clinica_id: paciente.clinica.id || auth.clinica?.id
            });
        } else {
            setData({
                nome: '',
                email: '',
                aniversario: '',
                telefone: '',
                clinica_id: auth.clinica?.id
            });
        }
    }, [paciente, isOpen]);

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault()

        if (paciente) {
            put(route('pacientes.update', paciente.id), { onSuccess: () => onClose() })
        } else {
            post(route('pacientes.store'), {
                onSuccess: () => {
                    setData({
                        nome: '',
                        email: '',
                        aniversario: '',
                        telefone: '',
                    })
                    onClose()
                }
            })
        }
    }
    return (
        <Modal isOpen={isOpen} onClose={onClose} title={paciente ? "Editar paciente" : 'Adicione um novo paciente'}>
            <FormTemplate onSubmit={handleSubmit} className="paciente-form" >
                <div className="form-grid">
                    {!paciente && can("profissionais.manage") ?
                        <InputGroup  label="Profissional" error={errors.nome} icon="fa-user" fullWidth>
                            <select name="profissional_id" id="profissional_id">
                                {
                                    profissionais.map(item=>(
                                        <option key={item.id} value={item.id}>{item.nome}</option>
                                    ))
                                }
                            </select>
                        </InputGroup>
                        :
                        ''
                    }
                    <InputGroup label="Nome do paciente" error={errors.nome} icon="fa-user">
                        <input type="text" name="nome" id="nome" placeholder="Ex: João Silva" value={data.nome} onChange={(e) => setData('nome', e.target.value)} />
                    </InputGroup>
                    <InputGroup label="Email do paciente" error={errors.email} icon="fa-envelope">
                        <input type="email" name="email" id="email" placeholder="email@exemplo.com" value={data.email} onChange={(e) => setData('email', e.target.value)} />
                    </InputGroup>
                    <InputGroup label="Telefone paciente" error={errors.telefone} icon="fa-user">
                        <input type="text" name="telefone" id="telefone" placeholder="16999999999" value={data.telefone} onChange={(e) => setData('telefone', e.target.value)} />
                    </InputGroup>
                    <InputGroup label="Aniversario do paciente" error={errors.aniversario} icon="fa-calendar">
                        <input type="date" name="aniversario" id="aniversario" value={data.aniversario} onChange={(e) => setData('aniversario', e.target.value)} />
                    </InputGroup>
                </div>

                <div className="form-actions">
                    <button type="submit" className="btn-submit" disabled={processing}>
                        <i className={`fa-solid ${paciente ? 'fa-check' : 'fa-paper-plane'}`}></i>
                        {paciente ? ' Salvar Alterações' : 'Criar paciente'}
                    </button>
                </div>
            </FormTemplate>
        </Modal>
    )
}