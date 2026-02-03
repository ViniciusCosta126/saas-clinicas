import React from "react";
import '../../../css/components/page-header.scss'

interface PageHeaderProps {
    titulo: string,
    subtitulo: string
}

export default function PageHeader({ titulo, subtitulo }: PageHeaderProps) {
    return (
        <div className="page-header">
            <div className="header-info">
                <h1>{titulo}</h1>
                <p>{subtitulo}</p>
            </div>
        </div>
    )
}