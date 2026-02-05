import { PropsWithChildren } from 'react'
import '../../css/dashboard/dashboard.scss'
import Sidebar from '../components/common/SideBar'
import Topbar from '../components/common/Topbar'
import Snackbar from '../components/common/Snackbar'

export default function DashboardLayout({ children }: PropsWithChildren) {
    return (
        <div className="dashboard">
            <Sidebar />
            <div className="dashboard-content">
                <Topbar />
                <main className="dashboard-main">
                    <Snackbar/>
                    {children}
                </main>
            </div>
        </div>
    )
}