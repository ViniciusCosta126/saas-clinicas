import React from 'react'
import { usePage } from '@inertiajs/react'
import { useEffect, useState } from 'react'
import '../../../css/components/snack-bar.scss'

type FlashType = 'success' | 'error' | 'warning' | 'info'

export default function Snackbar() {
    const { auth } = usePage().props as any
    const flash = auth?.flash

    const [type, setType] = useState<FlashType | null>(null)
    const [message, setMessage] = useState<string | null>(null)

    useEffect(() => {
        if (!flash) return

        const found = (Object.keys(flash) as FlashType[])
            .find(key => flash[key])

        if (found) {
            setType(found)
            setMessage(flash[found])

            const timer = setTimeout(() => {
                setType(null)
                setMessage(null)
            }, 4000)

            return () => clearTimeout(timer)
        }
    }, [flash])

    if (!type || !message) return null

    return (
        <div id="snack-container">
            <div
                className={`snack snack-${type}`}
                onClick={() => {
                    setType(null)
                    setMessage(null)
                }}
            >
                <div className="snack-icon">
                    {type === 'success' && <i className="fa-solid fa-circle-check" />}
                    {type === 'error' && <i className="fa-solid fa-circle-xmark" />}
                    {type === 'warning' && <i className="fa-solid fa-triangle-exclamation" />}
                    {type === 'info' && <i className="fa-solid fa-circle-info" />}
                </div>

                <div className="snack-content">
                    {message}
                </div>

                <div className="snack-close">&times;</div>
            </div>
        </div>
    )
}
