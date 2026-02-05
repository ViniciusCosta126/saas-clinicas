import { Link } from '@inertiajs/react'
import './index.scss'
interface PaginationLink {
  url: string | null
  label: string
  active: boolean
}

interface PaginationProps {
  links: PaginationLink[]
}

export default function Pagination({ links }: PaginationProps) {
  const translate = (label: string) => {
    return label
      .replace('Previous', 'Anterior')
      .replace('Next', 'Próximo')
      .replace('&laquo;', '‹')
      .replace('&raquo;', '›')
  }

  return (
    <nav className="pagination-area">
      <ul className="pagination">
        {links.map((link, index) => (
          <li
            key={index}
            className={`page-item ${link.active ? 'active' : ''} ${!link.url ? 'disabled' : ''}`}
          >
            {link.url ? (
              <Link
                href={link.url}
                preserveScroll
                preserveState
                className="page-link"
                dangerouslySetInnerHTML={{
                  __html: translate(link.label),
                }}
              />
            ) : (
              <span
                className="page-link"
                dangerouslySetInnerHTML={{
                  __html: translate(link.label),
                }}
              />
            )}
          </li>
        ))}
      </ul>
    </nav>
  )
}
