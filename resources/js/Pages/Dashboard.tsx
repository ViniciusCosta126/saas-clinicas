import React from 'react'
import DashboardLayout from '../Layouts/DashboardLayout'
import Kpis from '../components/common/Kpis'

interface DashBoardProps {
  profissionais: number,
  pacientes: number,
  agendamentos: number
}

export default function Dashboard({ profissionais, pacientes, agendamentos }: DashBoardProps) {

  return (
    <DashboardLayout>
      <Kpis profissionais={profissionais} pacientes={pacientes} agendamentos={agendamentos} />
    </DashboardLayout>
  )
}