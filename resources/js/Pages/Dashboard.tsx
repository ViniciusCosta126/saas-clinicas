import { router } from '@inertiajs/react'
import { useState } from 'react'
import { route } from 'ziggy-js'

import DashboardLayout from '../Layouts/DashboardLayout'
import Kpis from '../components/common/Kpis'
import Chart from '@/components/common/ui/Charts/Chart'
import DashboardFilters from '@/components/common/DashboardFilters/DashboardFilters'

import type { DashboardFiltersType } from '@/Types/DashboardFiltersType'

interface DashBoardProps {
  profissionais: number
  pacientes: number
  agendamentos: number
  faturamento: number

  faturamentoGrafico?: {
    data: string
    total: number
  }[]

  faturamentoPorProfissional?: {
    profissional: string
    total: number
  }[]

  faturamentoMensal?: {
    data: string
    total: number
  }[]

  comparativoMensal: {
    atual: number
    anterior: number
    variacao: number
  }

  mesSelecionado: string
}

export default function Dashboard({
  profissionais,
  pacientes,
  agendamentos,
  faturamento,
  faturamentoGrafico = [],
  faturamentoPorProfissional = [],
  faturamentoMensal = [],
  comparativoMensal,
  mesSelecionado,
}: DashBoardProps) {
  const [filters, setFilters] = useState<DashboardFiltersType>({
    periodo: '7',
    comparar: 'mes',
    mes: mesSelecionado,
  })

  function handleFilters(partial: Partial<DashboardFiltersType>) {
    const updated = { ...filters, ...partial }
    setFilters(updated)

    router.get(route('dashboard'), updated, {
      preserveState: true,
      preserveScroll: true,
      replace: true
    })
  }

  return (
    <DashboardLayout>
      <Kpis
        profissionais={profissionais}
        pacientes={pacientes}
        agendamentos={agendamentos}
        faturamento={faturamento}
        comparativoMensal={comparativoMensal}
      />

      <DashboardFilters
        filters={filters}
        onChange={handleFilters}
      />

      <div className="chart-container">
        <Chart
          type="bar"
          titulo="Faturamento últimos dias"
          labels={faturamentoGrafico.map(i => i.data)}
          data={faturamentoGrafico.map(i => i.total)}
        />

        <Chart
          type="doughnut"
          titulo="Faturamento por profissional"
          labels={faturamentoPorProfissional.map(i => i.profissional)}
          data={faturamentoPorProfissional.map(i => i.total)}
        />
      </div>

      <Chart
        type="line"
        titulo="Faturamento mensal (dia a dia)"
        labels={faturamentoMensal.map(i => i.data)}
        data={faturamentoMensal.map(i => i.total)}
      />
    </DashboardLayout>
  )
}
