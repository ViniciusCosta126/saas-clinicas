import { createRoot } from 'react-dom/client'
import { createInertiaApp } from '@inertiajs/react'

const pages = import.meta.glob('./Pages/**/*.tsx')

createInertiaApp({
  resolve: async (name) => {
    const page = pages[`./Pages/${name}.tsx`]
    if (!page) {
      throw new Error(`Página Inertia não encontrada: ${name}`)
    }

    return (await page()).default
  },

  setup({ el, App, props }) {
    createRoot(el).render(<App {...props} />)
  },
})
