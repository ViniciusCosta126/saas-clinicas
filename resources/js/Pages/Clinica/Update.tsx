import React from "react";
import DashboardLayout from "../../Layouts/DashboardLayout";
import PageHeader from "../../components/common/PageHeader";
import CardContainer from "../../components/common/CardContainer";
import FormEditClinica from "../../components/Clinica/FormEditClinica";
import { usePage } from "@inertiajs/react";
import { IPageProps } from "../../Types/PageProps";

export default function Update() {
    const { auth } = usePage<IPageProps>().props

    if (!auth.clinica) {
        return (
            <DashboardLayout>
                <PageHeader
                    titulo="Editar Clínica"
                    subtitulo="Clínica não encontrada."
                />
            </DashboardLayout>
        )
    }

    return (
        <DashboardLayout>
            <PageHeader
                titulo="Editar Clínica"
                subtitulo="Atualize as informações cadastrais e de contato."
            />
            <CardContainer>
                <FormEditClinica clinica={auth.clinica} />
            </CardContainer>
        </DashboardLayout>
    )
}