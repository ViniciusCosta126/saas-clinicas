import type {
  DashboardFiltersType,
  PeriodoFiltro,
  CompararFiltro,
} from '@/Types/DashboardFiltersType'
import './index.scss'
interface Props {
  filters: DashboardFiltersType
  onChange: (filters: Partial<DashboardFiltersType>) => void
}

export default function DashboardFilters({ filters, onChange }: Props) {
  return (
    <div className="dashboard-filters">
            <div className="filter-group">
        <label>Mês</label>
        <input
          type="month"
          value={filters.mes}
          onChange={e => onChange({ mes: e.target.value })}
        />
      </div>
      
      <div className="filter-group">
        <label>Comparar</label>
        <select
          value={filters.comparar ?? ''}
          onChange={e =>
            onChange({ comparar: e.target.value as CompararFiltro })
          }
        >
          <option value="mes">Mês anterior</option>
          <option value="ano">Mesmo mês ano passado</option>
        </select>
      </div>
    </div>
  )
}

