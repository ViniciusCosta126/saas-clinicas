import React, { useEffect, useRef, useState } from "react";
import { Link, usePage } from "@inertiajs/react";
import { route } from "ziggy-js";
import { IPageProps } from "../../Types/PageProps";

export default function Topbar() {
    const { auth } = usePage<IPageProps>().props

    const [open, setOpen] = useState(false);
    const menuRef = useRef<HTMLDivElement>(null);

    useEffect(() => {
        function handleClickOutside(event: MouseEvent) {
            if (menuRef.current && !menuRef.current.contains(event.target as Node)) {
                setOpen(false);
            }
        }

        document.addEventListener("click", handleClickOutside);
        return () => document.removeEventListener("click", handleClickOutside);
    })

    return (
        <header className="topbar">
            <div className="topbar-left">
                <h2 className="clinic-name">{auth.clinica?.nome_clinica}</h2>
            </div>

            <div className="topbar-right">
                <button className="btn-icon">
                    <i className="fa-regular fa-bell"></i>
                    <span className="badge"></span>
                </button>

                <div
                    ref={menuRef}
                    className={`user-menu ${open ? 'active' : ''}`} tabIndex={0}
                    onClick={() => setOpen(!open)}
                >
                    <div className="user-info">
                        <span className="user-name">{auth.user.name}</span>
                        <span className="user-role">{auth.user.role}</span>
                    </div>
                    <img src="https://placehold.co/38x38" alt="Avatar" className="user-avatar" />
                    <i className="fa-solid fa-chevron-down user-dropdown-icon"></i>

                    <div className="topbar-user-dropdown">
                        <a href={route('meu-perfil')}><i className="fa-regular fa-user"></i> Meu Perfil</a>
                        <a href={route('clinica.index')}><i className="fa-solid fa-hospital"></i> Dados da Clínica</a>
                        <hr />
                        <a href="/logout" className="logout"><i className="fa-solid fa-arrow-right-from-bracket"></i> Sair</a>
                    </div>
                </div>
            </div>
        </header>
    )
}