import { useMemo, useState } from 'react'

export function useTableFilter<T>(
  data: T[],
  searchableFields: (keyof T)[]
) {
  const [search, setSearch] = useState('')

  const filteredData = useMemo(() => {
    if (!search) return data

    return data.filter(item =>
      searchableFields.some(field =>
        String(item[field] ?? '')
          .toLowerCase()
          .includes(search.toLowerCase())
      )
    )
  }, [search, data, searchableFields])

  return {
    search,
    setSearch,
    filteredData
  }
}
