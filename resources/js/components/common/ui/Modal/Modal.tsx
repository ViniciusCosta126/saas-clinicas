import { ReactNode, useEffect, useState } from 'react'
import './index.scss'

interface ModalProps {
  isOpen: boolean
  title: string
  onClose: () => void
  children: ReactNode
  footer?: ReactNode
}

export default function Modal({
  isOpen,
  title,
  onClose,
  children,
  footer
}: ModalProps) {
  const [visible, setVisible] = useState(isOpen)
  const [closing, setClosing] = useState(false)

  useEffect(() => {
    if (isOpen) {
      setVisible(true)
      setClosing(false)
    } else if (visible) {
      setClosing(true)
      const timer = setTimeout(() => {
        setVisible(false)
        setClosing(false)
      }, 200) // mesmo tempo do modalOut

      return () => clearTimeout(timer)
    }
  }, [isOpen, visible])

  useEffect(() => {
    if (!visible) return

    const handleEsc = (e: KeyboardEvent) => {
      if (e.key === 'Escape') onClose()
    }

    window.addEventListener('keydown', handleEsc)
    return () => window.removeEventListener('keydown', handleEsc)
  }, [visible, onClose])

  if (!visible) return null

  return (
    <div
      className={`modal-overlay active ${closing ? 'closing' : ''}`}
      onClick={onClose}
    >
      <div className="modal-content" onClick={e => e.stopPropagation()}>
        <div className="modal-header">
          <h3>{title}</h3>
          <button className="modal-close" onClick={onClose}>
            <i className="fa-solid fa-xmark"></i>
          </button>
        </div>

        <div className="modal-body">{children}</div>

        {footer && <div className="modal-footer">{footer}</div>}
      </div>
    </div>
  )
}
