import React, { ReactNode } from 'react'
import './index.scss'

interface SmartTableProps {
  headers: string[]
  id?: string
  search: string
  onSearchChange: (value: string) => void
  children: ReactNode
}

export default function SmartTable({
  headers,
  id = 'smartTable',
  search,
  onSearchChange,
  children
}: SmartTableProps) {
  return (
    <div className="table-container">
      <div className="table-header-actions" style={{ padding: 20, display: 'flex', justifyContent: 'flex-end' }}>
        <div style={{ position: 'relative', width: 300 }}>
          <i
            className="fa-solid fa-magnifying-glass"
            style={{ position: 'absolute', left: 14, top: 12, color: '#94a3b8' }}
          />
          <input
            type="text"
            placeholder="Filtrar nesta página..."
            value={search}
            onChange={e => onSearchChange(e.target.value)}
            style={{
              width: '100%',
              padding: '10px 15px 10px 40px',
              border: '1px solid #e2e8f0',
              borderRadius: 10
            }}
          />
        </div>
      </div>

      <div className="table-responsive">
        <table className="custom-table" id={id}>
          <thead>
            <tr>
              {headers.map(h => (
                <th key={h} className={h === 'Ações' ? 'text-center' : ''}>
                  {h}
                </th>
              ))}
            </tr>
          </thead>

          <tbody>{children}</tbody>
        </table>
      </div>
    </div>
  )
}
