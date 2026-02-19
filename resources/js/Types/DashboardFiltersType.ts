export type PeriodoFiltro = '7' | '30' | 'mes' | 'ano'
export type CompararFiltro = 'mes' | 'ano'

export interface DashboardFiltersType {
  periodo: PeriodoFiltro
  comparar: CompararFiltro | null
  mes?: string
}
