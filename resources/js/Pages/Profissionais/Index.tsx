import CardContainer from "@/components/common/CardContainer";
import PageHeader from "@/components/common/PageHeader";
import Modal from "@/components/common/ui/Modal/Modal";
import SmartTable from "@/components/common/ui/SmartTable/SmartTable";
import useCrudModal from "@/hooks/useCrudModal";
import { useTableFilter } from "@/hooks/useTableFilter";
import DashboardLayout from "@/Layouts/DashboardLayout";
import { IPagination } from "@/Types/Pagination";
import { IProfissional } from "@/Types/Profissional";
import { IUser } from "@/Types/User";
import ProfissionalModal from "./ProfissionalModal";


interface ProfissionalProps {
    usuarios: IUser[];
    profissionais: IPagination<IProfissional>
}
export default function Index({ usuarios, profissionais }: ProfissionalProps) {
    const { filteredData, search, setSearch } = useTableFilter(profissionais.data, ['nome', 'email', 'especialidade', 'preco_sessao'])
    const {
        closeDeleteModal,
        confirmDelete,
        dataToDelete,
        isDeleteModalOpen,
        processingDelete,
        executeDelete,
        closeFormModal,
        isFormModalOpen,
        openCreate,
        openEdit,
        selectedData } = useCrudModal<IProfissional>()
    return (
        <DashboardLayout>
            <PageHeader titulo="Profissionais" subtitulo="Aqui você gerencia seus profissionais de forma simples: adicione, edite e exclua quando precisar." />
            <CardContainer>
                <div className="container-btns">
                    <div className="page-header-actions">
                        <button className="btn-primary" onClick={openCreate}>
                            <i className="fa-solid fa-plus"></i>
                            <span>Adicionar novo profissional</span>
                        </button>
                    </div>
                </div>
                <SmartTable
                    headers={['ID', 'Nome', 'Email', 'Especialidade', 'Preço Sessão', 'Ações']}
                    id="profissionaisTable"
                    search={search}
                    onSearchChange={setSearch}
                >
                    {
                        filteredData.length === 0 ? (
                            <tr>
                                <td colSpan={7} className="text-center" style={{ padding: 40, color: '#94a3b8' }}>
                                    Nenhum resultado encontrado para o filtro.
                                </td>
                            </tr>
                        ) : (
                            filteredData.map(profissional => (
                                <tr key={profissional.id}>
                                    <td className="col-id">#{profissional.id}</td>
                                    <td>{profissional.nome}</td>
                                    <td>
                                        <div className="contact-info">
                                            <small>
                                                <i className="fa-regular fa-envelope"></i>{profissional.email}
                                            </small>
                                        </div>
                                    </td>
                                    <td>{profissional.especialidade}</td>
                                    <td>{profissional.preco_sessao}</td>
                                    <td className="text-center">
                                        <div className="table-actions">
                                            <button className="btn-action edit" onClick={() => openEdit(profissional)}>
                                                <i className="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <button className="btn-action delete" onClick={() => confirmDelete(profissional)}>
                                                <i className="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            ))
                        )
                    }
                </SmartTable>

                <ProfissionalModal usuarios={usuarios} profissional={selectedData} isOpen={isFormModalOpen} onClose={closeFormModal} />
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
                            onClick={() => executeDelete('profissionais.delete')}
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
                    <p>Tem certeza que deseja excluir o profissional <strong>{dataToDelete?.nome}</strong>?
                        Esta ação não poderá ser desfeita.</p>
                </Modal>
            </CardContainer>
        </DashboardLayout>
    )
}