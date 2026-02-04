import CardContainer from "@/components/common/CardContainer";
import PageHeader from "@/components/common/PageHeader";
import Pagination from "@/components/common/ui/Pagination/Index";
import SmartTable from "@/components/common/ui/SmartTable/SmartTable";
import { useTableFilter } from "@/hooks/useTableFilter";
import DashboardLayout from "@/Layouts/DashboardLayout";
import { IPagination } from "@/Types/Pagination";
import { IUser } from "@/Types/User";
import { formatDateBr } from "@/utils/format";
import { use, useState } from "react";
import { UserModal } from "./UserModal";
import Modal from "@/components/common/ui/Modal/Modal";
import { route } from "ziggy-js";
import { router } from "@inertiajs/react";


interface IndexUsuariosProps {
    usuarios: IPagination<IUser>
}
export default function Index({ usuarios }: IndexUsuariosProps) {
    const { search, setSearch, filteredData } = useTableFilter(usuarios.data, [
        'id',
        'name',
        'email',
        'cpf',
        'role'
    ])
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [selectedUser, setSelectedUser] = useState<IUser | null>(null);

    const [isModalDeleteOpen, setIsModalDeleteOpen] = useState(false);
    const [userToDelete, setUserToDelete] = useState<IUser | null>(null);
    const [loadingDelete, setLoadingDelete] = useState(false);

    const confirmDelete = (usuario: IUser) => {
        setUserToDelete(usuario);
        setIsModalDeleteOpen(true);
    };

    const handleDelete = () => {
        if (!userToDelete) return;

        router.delete(route('usuarios.delete', userToDelete.id), {
            onBefore: () => setLoadingDelete(true),
            onSuccess: () => {
                setIsModalDeleteOpen(false);
                setUserToDelete(null);
            },
            onFinish: () => setLoadingDelete(false),
            preserveScroll: true
        });
    };
    const handleEdit = (usuario: IUser) => {
        setSelectedUser(usuario)
        setIsModalOpen(true)
    }

    const handleCreate = () => {
        setSelectedUser(null)
        setIsModalOpen(true)
    }

    return (
        <DashboardLayout>
            <PageHeader titulo="Todos os usuários" subtitulo="Gerencie seus usuários aqui" />
            <CardContainer>
                <div className="container-btns">
                    <div className="page-header-actions">
                        <button className="btn-primary" onClick={handleCreate}>
                            <i className="fa-solid fa-plus"></i>
                            <span>Adicionar novo usuário</span>
                        </button>
                    </div>
                </div>
                <SmartTable
                    headers={['ID', 'Nome', 'CPF', 'Contato', 'Função', 'Criado em', 'Ações']}
                    id="usuarioTable"
                    search={search}
                    onSearchChange={setSearch}
                >
                    {filteredData.length === 0 ? (
                        <tr>
                            <td colSpan={7} className="text-center" style={{ padding: 40, color: '#94a3b8' }}>
                                Nenhum resultado encontrado para o filtro.
                            </td>
                        </tr>
                    ) : (
                        filteredData.map(usuario => (
                            <tr key={usuario.id}>
                                <td>{usuario.id}</td>
                                <td>{usuario.name}</td>
                                <td>{usuario.cpf}</td>
                                <td>{usuario.email}</td>
                                <td>{usuario.role}</td>
                                <td>{formatDateBr(usuario.created_at)}</td>
                                <td className="text-center">
                                    <div className="table-actions">
                                        <button className="btn-action edit" onClick={() => handleEdit(usuario)}>
                                            <i className="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button className="btn-action delete" onClick={()=>confirmDelete(usuario)}>
                                            <i className="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        ))
                    )}
                </SmartTable>
                <Pagination links={usuarios.links} />

                <UserModal user={selectedUser} isOpen={isModalOpen} onClose={() => setIsModalOpen(false)} />
                <Modal title="Confirmar ação" isOpen={isModalDeleteOpen}
                    onClose={() => !loadingDelete && setIsModalDeleteOpen(false)}
                    footer={<>
                        <button
                            className="btn-cancel"
                            onClick={() => setIsModalDeleteOpen(false)}
                            disabled={loadingDelete}
                        >
                            Cancelar
                        </button>
                        <button
                            className="btn-submit"
                            onClick={handleDelete}
                            disabled={loadingDelete}
                        >
                            {loadingDelete ? (
                                <>
                                    <i className="fa-solid fa-spinner fa-spin"></i> Excluindo...
                                </>
                            ) : (
                                'Confirmar Exclusão'
                            )}
                        </button>
                    </>}
                >
                    <p>Tem certeza que deseja excluir o usuário <strong>{userToDelete?.name}</strong>?
                        Esta ação não poderá ser desfeita.</p>
                </Modal>
            </CardContainer>
        </DashboardLayout>
    )
}