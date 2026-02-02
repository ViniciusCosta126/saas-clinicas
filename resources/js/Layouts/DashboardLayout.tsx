import React, { PropsWithChildren } from 'react'
import '../../css/dashboard/dashboard.scss'
import Sidebar from '../components/common/SideBar'
import Topbar from '../components/common/Topbar'

export default function DashboardLayout({ children }: PropsWithChildren) {
    return (
        <div className="dashboard">
            <Sidebar />
            <div className="dashboard-content">
                <Topbar />
                <main className="dashboard-main">
                    {children}
                </main>
            </div>
        </div>
    )
}