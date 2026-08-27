import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'
import type { ComponentType } from 'react'
import '../css/app.css'

type ReactPage = ComponentType<Record<string, unknown>>

const pages = import.meta.glob<{ default: ReactPage }>('./Pages/**/*.tsx')

createInertiaApp({
    resolve: async (name) => {
        const module = await pages[`./Pages/${name}.tsx`]()

        return module.default
    },
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />)
    },
})