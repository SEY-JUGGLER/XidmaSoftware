import type { ReactNode } from 'react'

export default function PageHero({
    eyebrow,
    title,
    description,
    children,
}: {
    eyebrow?: string
    title: string
    description?: string
    children?: ReactNode
}) {
    return (
        <section className="relative overflow-hidden bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800">
            <div className="bg-grid-light absolute inset-0 [mask-image:radial-gradient(ellipse_at_top,black,transparent_75%)]" />
            <div
                className="animate-float-slow absolute -top-24 right-0 h-72 w-72 rounded-full bg-sky-400/20 blur-3xl"
                aria-hidden="true"
            />
            <div
                className="animate-float absolute -bottom-24 left-0 h-72 w-72 rounded-full bg-orange-400/10 blur-3xl"
                aria-hidden="true"
            />

            <div className="relative mx-auto max-w-7xl px-4 py-20 sm:py-24">
                {eyebrow && (
                    <p className="text-sm font-semibold tracking-wide text-orange-400 uppercase">{eyebrow}</p>
                )}
                <h1 className="mt-3 max-w-3xl text-4xl font-bold text-white md:text-5xl">{title}</h1>
                {description && <p className="mt-5 max-w-2xl text-lg text-blue-100">{description}</p>}
                {children && <div className="mt-8">{children}</div>}
            </div>
        </section>
    )
}
