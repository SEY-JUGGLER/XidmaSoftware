import { Link } from '@inertiajs/react'
import PageHero from '../../Components/PageHero'
import AppLayout from '../../Components/AppLayout'
import Icon, { type IconName } from '../../Components/Icon'
import Reveal from '../../Components/Reveal'
import { resolveImageUrl } from '../../lib/image'

export default function ServicesIndex({
    services,
}: {
    services: Array<{
        id: number
        slug: string
        titre: string
        description_courte: string
        icone?: string | null
        image?: string | null
    }>
}) {
    return (
        <AppLayout title="Services">
            <PageHero
                eyebrow="Nos services"
                title="Une expertise complète pour votre transformation"
                description="Un accompagnement de bout en bout pour digitaliser, automatiser et sécuriser vos processus métier."
            />

            <section className="mx-auto max-w-7xl px-4 py-16 sm:px-6">
                <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    {services.map((service, index) => {
                        const image = resolveImageUrl(service.image)

                        return (
                            <Reveal key={service.id} delay={index * 90}>
                                <Link
                                    href={`/services/${service.slug}`}
                                    className="group flex h-full flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1.5 hover:border-blue-100 hover:shadow-xl hover:shadow-blue-900/10"
                                >
                                    {image && (
                                        <div className="h-36 overflow-hidden">
                                            <img
                                                src={image}
                                                alt={service.titre}
                                                className="h-full w-full object-cover"
                                                loading="lazy"
                                            />
                                        </div>
                                    )}
                                    <div className="flex flex-1 flex-col p-6">
                                        <span className="flex size-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-blue-900 text-white shadow-md shadow-blue-900/20 transition-transform duration-300 group-hover:scale-110">
                                            <Icon
                                                name={(service.icone as IconName) ?? 'sparkles'}
                                                className="size-6"
                                            />
                                        </span>
                                        <h2 className="mt-5 text-lg font-semibold text-blue-950">{service.titre}</h2>
                                        <p className="mt-3 flex-1 text-sm leading-relaxed text-gray-600">
                                            {service.description_courte}
                                        </p>
                                        <span className="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-orange-500">
                                            En savoir plus
                                            <Icon
                                                name="arrow-right"
                                                className="size-3.5 transition-transform group-hover:translate-x-1"
                                            />
                                        </span>
                                    </div>
                                </Link>
                            </Reveal>
                        )
                    })}
                </div>
            </section>
        </AppLayout>
    )
}
