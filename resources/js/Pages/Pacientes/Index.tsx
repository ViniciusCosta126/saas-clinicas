import CardContainer from "@/components/common/CardContainer";
import PageHeader from "@/components/common/PageHeader";
import Modal from "@/components/common/ui/Modal/Modal";
import SemResultados from "@/components/common/ui/Sem-Resultados/SemResultados";
import SmartTable from "@/components/common/ui/SmartTable/SmartTable";
import useCrudModal from "@/hooks/useCrudModal";
import { useTableFilter } from "@/hooks/useTableFilter";
import DashboardLayout from "@/Layouts/DashboardLayout";
import { IPaciente } from "@/Types/Paciente";
import { IPagination } from "@/Types/Pagination";
import { formatDateBr } from "@/utils/format";
import PacienteModal from "./PacienteModal";
import { IProfissional } from "@/Types/Profissional";


interface PacientesPageProps {
    pacientes: IPagination<IPaciente>
    profissionais:IProfissional[];
}
export default function Index({ pacientes,profissionais }: PacientesPageProps) {
    const { filteredData, search, setSearch } = useTableFilter(pacientes.data, ['nome', 'email', 'telefone'])
    const {
        closeDeleteModal,
        confirmDelete,
        executeDelete,
        dataToDelete,
        isDeleteModalOpen,
        processingDelete,
        closeFormModal,
        openCreate,
        openEdit,
        selectedData,
        isFormModalOpen
    } = useCrudModal<IPaciente>();
    return (
        <DashboardLayout>
            <PageHeader titulo="Pacientes" subtitulo="Aqui você gerencia seus pacientes de forma simples: adicione, edite e exclua quando precisar." />
            <CardContainer>
                <div className="container-btns">
                    <div className="page-header-actions">
                        <button className="btn-primary" onClick={openCreate}>
                            <i className="fa-solid fa-plus"></i>
                            <span>Adicionar novo paciente</span>
                        </button>
                    </div>
                </div>
                <SmartTable id="pacientesTable" headers={['ID', 'Nome', 'Email', 'Aniversario', 'Clinica', 'Ações']} onSearchChange={setSearch} search={search}>
                    {
                        filteredData.length === 0 ? (
                            <SemResultados />
                        ) :
                            (
                                filteredData.map(paciente => (
                                    <tr key={paciente.id}>
                                        <td className="col-id">#{paciente.id}</td>
                                        <td>{paciente.nome}</td>
                                        <td>
                                            <div className="contact-info">
                                                <small><i className="fa-regular fa-envelope"></i>{paciente.email}</small>
                                                <small><i className="fa-solid fa-phone"></i>{paciente.telefone}</small>
                                            </div>
                                        </td>
                                        <td>{formatDateBr(paciente.aniversario)}</td>
                                        <td>{paciente.clinica.nome_clinica}</td>
                                        <td className="text-center">
                                            <div className="table-actions">
                                                <button className="btn-action edit" onClick={() => openEdit(paciente)}>
                                                    <i className="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <button className="btn-action delete" onClick={() => confirmDelete(paciente)}>
                                                    <i className="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))
                            )
                    }
                </SmartTable>

                <PacienteModal profissionais={profissionais} isOpen={isFormModalOpen} onClose={closeFormModal} paciente={selectedData} />
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
                            onClick={() => executeDelete('pacientes.delete')}
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