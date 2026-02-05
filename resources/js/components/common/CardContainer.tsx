import React, { PropsWithChildren } from "react";
import '../../../css/components/card-container.scss'

export default function CardContainer({ children }: PropsWithChildren) {
    return (
        <div className="card-container">
            {children}
        </div>
    )
}