import { Link, usePage } from "@inertiajs/react";
import React from "react";
import { route } from "ziggy-js";
import { IPageProps } from "../../Types/PageProps";

export default function Sidebar() {
    const { auth } = usePage<IPageProps>().props

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

                <Link href={route('agendamento.index')}>
                    <i className="fa-solid fa-calendar-days"></i>
                    Agenda
                </Link>

                {can('pacientes.manage') && (
                    <Link href={route('pacientes.index')}>
                        <i className="fa-solid fa-user-injured"></i>
                        Pacientes
                    </Link>
                )}

                {can('profissionais.manage') && (
                    <Link href={route('profissionais.index')}>
                        <i className="fa-solid fa-user-doctor"></i>
                        Profissionais
                    </Link>
                )}

                {/* <Link href="#">
                    <i className="fa-solid fa-money-bill-trend-up"></i>
                    Financeiro
                </Link> */}

                {can('config.manage') && (
                    <Link href={route('config.manage')}>
                        <i className="fa-solid fa-gear"></i>
                        Configurações
                    </Link>
                )}

                {can('usuarios') && (
                    <Link href={route('usuarios.index')}>
                        <i className="fa-solid fa-user"></i>
                        Usuários
                    </Link>
                )}
            </nav>
        </aside>
    )
}