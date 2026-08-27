import { Link } from '@inertiajs/react'
import { useEffect, useState, type ReactNode } from 'react'
import Icon from './Icon'

const NAV_LINKS = [
    { href: '/services', label: 'Services' },
    { href: '/realisations', label: 'Réalisations' },
    { href: '/blog', label: 'Blog' },
    { href: '/contact', label: 'Contact' },
]

export default function AppLayout({
    children,
    title,
    description,
}: {
    children: ReactNode
    title?: string
    description?: string
}) {
    const [mobileOpen, setMobileOpen] = useState(false)

    useEffect(() => {
        document.title = title ? `${title} — Xidma Software` : 'Xidma Software'
        if (description) {
            const meta = document.querySelector('meta[name="description"]')
            if (meta) {
                meta.setAttribute('content', description)
            }
        }
    }, [title, description])

    useEffect(() => {
        setMobileOpen(false)
    }, [title])

    return (
        <div className="min-h-screen bg-white antialiased">
            <header className="sticky top-0 z-50 border-b border-gray-100 bg-white/80 backdrop-blur-md">
                <nav className="mx-auto flex max-w-7xl items-center justify-between px-4 py-3.5 sm:px-6">
                    <Link href="/" className="group flex items-center" aria-label="Xidma Software - Accueil">
                        <img
                            src="/images/logo.png"
                            alt="Xidma Software"
                            className="h-11 w-44 object-cover object-center transition-transform group-hover:scale-105"
                        />
                    </Link>

                    <div className="hidden items-center gap-8 text-sm font-medium text-gray-600 md:flex">
                        {NAV_LINKS.map((link) => (
                            <Link key={link.href} href={link.href} className="group relative py-1">
                                {link.label}
                                <span className="absolute inset-x-0 -bottom-0.5 h-0.5 origin-left scale-x-0 rounded-full bg-blue-600 transition-transform duration-300 group-hover:scale-x-100" />
                            </Link>
                        ))}
                    </div>

                    <div className="hidden md:block">
                        <Link
                            href="/contact"
                            className="rounded-lg bg-blue-950 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800"
                        >
                            Demander un devis
                        </Link>
                    </div>

                    <button
                        type="button"
                        onClick={() => setMobileOpen((open) => !open)}
                        className="flex size-10 items-center justify-center rounded-lg text-blue-950 hover:bg-blue-50 md:hidden"
                        aria-label={mobileOpen ? 'Fermer le menu' : 'Ouvrir le menu'}
                        aria-expanded={mobileOpen}
                    >
                        <Icon name={mobileOpen ? 'close' : 'menu'} className="size-6" />
                    </button>
                </nav>

                {mobileOpen && (
                    <div className="animate-fade-in border-t border-gray-100 bg-white px-4 pt-2 pb-6 md:hidden">
                        <div className="flex flex-col gap-1">
                            {NAV_LINKS.map((link) => (
                                <Link
                                    key={link.href}
                                    href={link.href}
                                    className="rounded-lg px-3 py-3 text-base font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-900"
                                >
                                    {link.label}
                                </Link>
                            ))}
                        </div>
                        <Link
                            href="/contact"
                            className="mt-4 block rounded-lg bg-blue-950 px-5 py-3 text-center text-sm font-semibold text-white"
                        >
                            Demander un devis
                        </Link>
                    </div>
                )}
            </header>

            <main>{children}</main>

            <footer className="relative overflow-hidden bg-blue-950">
                <div className="bg-grid-light absolute inset-0 opacity-40" aria-hidden="true" />
                <div className="relative mx-auto max-w-7xl px-4 py-16 sm:px-6">
                    <div className="grid gap-10 md:grid-cols-4">
                        <div className="md:col-span-2">
                            <Link href="/" className="inline-flex items-center rounded-xl bg-white p-2.5" aria-label="Xidma Software - Accueil">
                                <img
                                    src="/images/logo.jpeg"
                                    alt="Xidma Software"
                                    className="h-10 w-40 object-cover object-center"
                                />
                            </Link>
                            <p className="mt-4 max-w-sm text-sm leading-relaxed text-blue-200">
                                Conseil, digitalisation et automatisation : nous accompagnons les PME, indépendants
                                et institutions dans leur transformation numérique.
                            </p>
                            <a
                                href="mailto:contact@xidma-software.sn"
                                className="mt-5 inline-flex items-center gap-2 text-sm font-medium text-blue-100 hover:text-white"
                            >
                                <Icon name="mail" className="size-4" />
                                contact@xidma-software.sn
                            </a>
                        </div>

                        <div>
                            <p className="text-sm font-semibold text-white">Navigation</p>
                            <div className="mt-4 flex flex-col gap-3 text-sm text-blue-200">
                                {NAV_LINKS.map((link) => (
                                    <Link key={link.href} href={link.href} className="transition hover:text-white">
                                        {link.label}
                                    </Link>
                                ))}
                            </div>
                        </div>

                        <div>
                            <p className="text-sm font-semibold text-white">Légal</p>
                            <div className="mt-4 flex flex-col gap-3 text-sm text-blue-200">
                                <Link href="/mentions-legales" className="transition hover:text-white">
                                    Mentions légales
                                </Link>
                                <Link href="/politique-confidentialite" className="transition hover:text-white">
                                    Confidentialité
                                </Link>
                            </div>
                        </div>
                    </div>

                    <div className="mt-12 flex flex-col items-center justify-between gap-4 border-t border-white/10 pt-8 text-sm text-blue-300 md:flex-row">
                        <p>© {new Date().getFullYear()} Xidma Software. Tous droits réservés.</p>
                    </div>
                </div>
            </footer>
        </div>
    )
}
