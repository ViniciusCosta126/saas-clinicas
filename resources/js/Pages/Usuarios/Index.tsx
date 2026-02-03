import CardContainer from "@/components/common/CardContainer";
import PageHeader from "@/components/common/PageHeader";
import Pagination from "@/components/common/ui/Pagination/Index";
import SmartTable from "@/components/common/ui/SmartTable/SmartTable";
import { useTableFilter } from "@/hooks/useTableFilter";
import DashboardLayout from "@/Layouts/DashboardLayout";
import { IPagination } from "@/Types/Pagination";
import { IUser } from "@/Types/User";
import { formatDateBr } from "@/utils/format";
import { useMemo, useState } from "react";


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

    return (
        <DashboardLayout>
            <PageHeader titulo="Todos os usuários" subtitulo="Gerencie seus usuários aqui" />

            <CardContainer>
                <div className="container-btns">
                    <div className="page-header-actions">
                        <button className="btn-primary">
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
                                        <button className="btn-action edit">
                                            <i className="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button className="btn-action delete">
                                            <i className="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        ))
                    )}
                </SmartTable>
                <Pagination links={usuarios.links} />
            </CardContainer>
        </DashboardLayout>
    )
}