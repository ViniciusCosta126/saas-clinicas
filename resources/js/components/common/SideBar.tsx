import { Link, usePage } from "@inertiajs/react";
import React from "react";

export default function Sidebar() {
    const { auth } = usePage().props as any

    const permissions: string[] = auth?.permissions ?? [];

    const can = (permission: string) => permissions.includes(permission);

    return (
        <aside className="sidebar">
            <div className="sidebar-logo">Lumina</div>

            <nav className="sidebar-nav">
                <Link href="/dashboard">
                    <i className="fa-solid fa-chart-line"></i>
                    Dashboard
                </Link>

                <Link href="/agendamentos">
                    <i className="fa-solid fa-calendar-days"></i>
                    Agenda
                </Link>

                {can('pacientes.manage') && (
                    <Link href="/pacientes">
                        <i className="fa-solid fa-user-injured"></i>
                        Pacientes
                    </Link>
                )}

                {can('profissionais.manage') && (
                    <Link href="/profissionais">
                        <i className="fa-solid fa-user-doctor"></i>
                        Profissionais
                    </Link>
                )}

                <Link href="#">
                    <i className="fa-solid fa-money-bill-trend-up"></i>
                    Financeiro
                </Link>

                {can('config.manage') && (
                    <Link href="/clinica/configuracoes-clinica">
                        <i className="fa-solid fa-gear"></i>
                        Configurações
                    </Link>
                )}

                {can('usuarios') && (
                    <Link href="/usuarios">
                        <i className="fa-solid fa-user"></i>
                        Usuários
                    </Link>
                )}
            </nav>
        </aside>
    )
}