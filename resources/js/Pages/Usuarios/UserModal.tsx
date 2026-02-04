import FormTemplate from "@/components/common/FormTemplate";
import InputGroup from "@/components/common/ui/Formulario/InputGroup";
import Modal from "@/components/common/ui/Modal/Modal";
import { IUser } from "@/Types/User";
import { useForm } from "@inertiajs/react";
import { FormEvent, useEffect } from "react";
import { route } from "ziggy-js";


interface UserFormProps {
    user?: IUser | null;
    isOpen: boolean;
    onClose: () => void;
}
export function UserModal({ user, isOpen, onClose }: UserFormProps) {

    const { data, setData, post, put, processing, errors, reset } = useForm({
        name: user?.name || "",
        email: user?.email || "",
        telefone: user?.telefone || "",
        cpf: user?.cpf || '',
        role: user?.role || ''
    })

    useEffect(() => {
        if (user) {
            setData({
                name: user.name || '',
                email: user.email || '',
                telefone: user.telefone || '',
                cpf: user.cpf || '',
                role: user.role || '',
            });
        } else {
            setData({
                name: '',
                email: '',
                telefone: '',
                cpf: '',
                role: '',
            });
        }
    }, [user, isOpen]);

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault()
        if (user) {
            put(route('usuarios.update', user.id), { onSuccess: () => onClose() })
        } else {
            post(route('usuarios.invites.store'), {
                onSuccess: () => {
                    setData({
                        name: '',
                        email: '',
                        telefone: '',
                        cpf: '',
                        role: '',
                    });
                    onClose();
                }
            })
        }
    }

    return (
        <Modal isOpen={isOpen} title={user ? "Editar usuario" : "Adicionar novo usuario"} onClose={onClose}>
            <FormTemplate onSubmit={handleSubmit} className="invite-form">
                <div className="form-grid">
                    <InputGroup label="name Completo" icon="fa-user" error={errors.name}>
                        <input
                            type="text"
                            value={data.name}
                            onChange={e => setData('name', e.target.value)}
                            placeholder="Ex: João Silva"
                        />
                    </InputGroup>
                    <InputGroup label="E-mail" icon="fa-envelope" error={errors.email}>
                        <input
                            type="email"
                            value={data.email}
                            onChange={e => setData('email', e.target.value)}
                            placeholder="email@exemplo.com"
                        />
                    </InputGroup>

                    <InputGroup label="Telefone" icon="fa-phone" error={errors.telefone}>
                        <input
                            type="text"
                            value={data.telefone}
                            onChange={e => setData('telefone', e.target.value)}
                        />
                    </InputGroup>

                    <InputGroup label="CPF" icon="fa-address-card" error={errors.cpf}>
                        <input
                            type="text"
                            value={data.cpf}
                            onChange={e => setData('cpf', e.target.value)}
                        />
                    </InputGroup>

                    <InputGroup label="Função no Sistema" icon="fa-briefcase" error={errors.role} fullWidth>
                        <select value={data.role} onChange={e => setData('role', e.target.value)}>
                            <option value="" disabled>Selecione uma função...</option>
                            <option value="admin">Administrador</option>
                            <option value="profissional">Profissional / Médico</option>
                            <option value="recepcao">Recepção</option>
                            <option value="financeiro">Financeiro</option>
                        </select>
                    </InputGroup>
                </div>

                <div className="form-actions">
                    <button type="submit" className="btn-submit" disabled={processing}>
                        <i className={`fa-solid ${user ? 'fa-check' : 'fa-paper-plane'}`}></i>
                        {user ? ' Salvar Alterações' : ' Enviar Convite'}
                    </button>
                </div>
            </FormTemplate>
        </Modal>
    )
}