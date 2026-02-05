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
import useCrudModal from "@/hooks/useCrudModal";
import SemResultados from "@/components/common/ui/Sem-Resultados/SemResultados";


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

    const {
        isFormModalOpen,
        selectedData,
        openCreate,
        openEdit,
        closeFormModal,
        isDeleteModalOpen,
        dataToDelete,
        processingDelete,
        confirmDelete,
        closeDeleteModal,
        executeDelete
    } = useCrudModal<IUser>()

    return (
        <DashboardLayout>
            <PageHeader titulo="Todos os usuários" subtitulo="Gerencie seus usuários aqui" />
            <CardContainer>
                <div className="container-btns">
                    <div className="page-header-actions">
                        <button className="btn-primary" onClick={openCreate}>
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
                        <SemResultados />
                    ) : (
                        filteredData.map(usuario => (
                            <tr key={usuario.id}>
                                <td>{usuario.id}</td>
                                <td>{usuario.name}</td>
                                <td>{usuario.cpf}</td>
                                <td>
                                    <div className="contact-info">
                                        <small><i className="fa-regular fa-envelope"></i>{usuario.email}</small>
                                        {usuario.telefone ? (<small><i className="fa-solid fa-phone"></i>{usuario.telefone}</small>) : ''}
                                    </div>
                                </td>
                                <td>{usuario.role}</td>
                                <td>{formatDateBr(usuario.created_at)}</td>
                                <td className="text-center">
                                    <div className="table-actions">
                                        <button className="btn-action edit" onClick={() => openEdit(usuario)}>
                                            <i className="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button className="btn-action delete" onClick={() => confirmDelete(usuario)}>
                                            <i className="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        ))
                    )}
                </SmartTable>
                <Pagination links={usuarios.links} />

                <UserModal user={selectedData} isOpen={isFormModalOpen} onClose={closeFormModal} />

                <Modal title="Confirmar ação" isOpen={isDeleteModalOpen}
                    onClose={closeDeleteModal}
                    footer={<>
                        <button
                            className="btn-cancel"
                            onClick={closeDeleteModal}
                            disabled={processingDelete}
                        >
                            Cancelar
                        </button>
                        <button
                            className="btn-submit"
                            onClick={() => executeDelete('usuarios.delete')}
                            disabled={processingDelete}
                        >
                            {processingDelete ? (
                                <>
                                    <i className="fa-solid fa-spinner fa-spin"></i> Excluindo...
                                </>
                            ) : (
                                'Confirmar Exclusão'
                            )}
                        </button>
                    </>}
                >
                    <p>Tem certeza que deseja excluir o usuário <strong>{dataToDelete?.name}</strong>?
                        Esta ação não poderá ser desfeita.</p>
                </Modal>
            </CardContainer>
        </DashboardLayout>
    )
}