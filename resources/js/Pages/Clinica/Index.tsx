import React from "react";
import DashboardLayout from "../../Layouts/DashboardLayout";
import PageHeader from "../../components/common/PageHeader";
import { usePage } from "@inertiajs/react";
import { formatDateBr, padLeft } from "../../utils/format";
import '../../../css/dashboard/clinica/index.scss'

export default function Index() {
    const { auth } = usePage().props as any
    return (
        <DashboardLayout>
            <PageHeader titulo="Dados da Clínica" subtitulo="Informações de registro e contato da unidade." />
            <div className="clinic-display-grid">
                <div className="info-card">
                    <div className="info-card-header">
                        <div className="icon-box">
                            <i className="fa-solid fa-hospital"></i>
                        </div>
                        <div>
                            <h3>{auth.clinica.nome_clinica}</h3>
                            <span>ID do Registro: #{padLeft(auth.clinica.id, 5)}</span>
                        </div>
                    </div>

                    <div className="info-card-body">
                        <div className="info-item">
                            <label>Responsável Técnico</label>
                            <p>{auth.clinica.nome_responsavel}</p>
                        </div>

                        <div className="info-item">
                            <label>E-mail de Contato</label>
                            <p><i className="fa-regular fa-envelope"></i> {auth.clinica.email}</p>
                        </div>

                        <div className="info-item">
                            <label>Telefone / WhatsApp</label>
                            <p><i className="fa-solid fa-phone"></i> {auth.clinica.telefone}</p>
                        </div>
                    </div>
                </div>

                <div className="info-card status-card">
                    <div className="status-badge active">
                        <i className="fa-solid fa-circle-check"></i> Unidade Ativa
                    </div>
                    <p className="since-text">Cliente desde {formatDateBr(auth.clinica.created_at)}</p>
                    {/* <hr />
                    <div className="support-info">
                        <p>Precisa alterar algum dado? Entre em contato com o suporte do sistema.</p>
                        <a href="#" className="btn-support">Falar com Suporte</a>
                    </div> */}
                </div>
            </div>
        </DashboardLayout>
    )
}