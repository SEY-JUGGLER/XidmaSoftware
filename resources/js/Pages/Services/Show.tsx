import { Link } from '@inertiajs/react'
import AppLayout from '../../Components/AppLayout'
import Icon, { type IconName } from '../../Components/Icon'
import PageHero from '../../Components/PageHero'
import Reveal from '../../Components/Reveal'
import { resolveImageUrl } from '../../lib/image'

type Service = {
    id: number
    titre: string
    description_courte: string
    description_longue: string
    icone: string | null
    image: string | null
}

type Realisation = {
    id: number
    slug: string
    titre: string
    client: string
    image_cover: string | null
}

function initials(name: string): string {
    return name
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((part) => part[0]?.toUpperCase())
        .join('')
}

export default function ServiceShow({
    service,
    realisations,
}: {
    service: Service
    realisations: Realisation[]
}) {
    return (
        <AppLayout title={service.titre} description={service.description_courte}>
            <PageHero eyebrow="Nos services" title={service.titre} description={service.description_courte}>
                <div className="flex items-center gap-4">
                    <span className="flex size-14 items-center justify-center rounded-2xl bg-white/10 text-white ring-1 ring-white/20">
                        <Icon name={(service.icone as IconName) ?? 'sparkles'} className="size-7" />
                    </span>
                    <Link
                        href="/contact"
                        className="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-6 py-3 font-semibold text-white shadow-lg shadow-orange-950/30 transition hover:bg-orange-400"
                    >
                        Demander un devis
                        <Icon name="arrow-right" className="size-4" />
                    </Link>
                </div>
            </PageHero>

            {resolveImageUrl(service.image) && (
                <section className="mx-auto max-w-4xl px-4 pt-10 sm:px-6">
                    <Reveal>
                        <img
                            src={resolveImageUrl(service.image)!}
                            alt={service.titre}
                            className="aspect-video w-full rounded-2xl object-cover shadow-lg"
                            loading="lazy"
                        />
                    </Reveal>
                </section>
            )}

            <section className="mx-auto max-w-4xl px-4 py-16 sm:px-6">
                <Reveal>
                    <p className="text-lg leading-relaxed text-gray-700">{service.description_longue}</p>
                </Reveal>
            </section>

            {realisations.length > 0 && (
                <section className="bg-blue-50/60 py-16">
                    <div className="mx-auto max-w-4xl px-4 sm:px-6">
                        <Reveal>
                            <h2 className="text-2xl font-bold text-blue-950">Réalisations associées</h2>
                        </Reveal>
                        <div className="mt-8 grid gap-6 md:grid-cols-2">
                            {realisations.map((realisation, index) => (
                                <Reveal key={realisation.id} delay={index * 90}>
                                    <Link
                                        href={`/realisations/${realisation.slug}`}
                                        className="group flex h-full flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-blue-900/10"
                                    >
                                        <div className="relative flex h-28 items-center justify-center overflow-hidden bg-gradient-to-br from-blue-800 via-blue-700 to-sky-500">
                                            {resolveImageUrl(realisation.image_cover) ? (
                                                <img
                                                    src={resolveImageUrl(realisation.image_cover)!}
                                                    alt={realisation.titre}
                                                    className="absolute inset-0 h-full w-full object-cover"
                                                    loading="lazy"
                                                />
                                            ) : (
                                                <span className="relative text-xl font-bold text-white/90">
                                                    {initials(realisation.client)}
                                                </span>
                                            )}
                                        </div>
                                        <div className="flex flex-1 flex-col p-6">
                                            <h3 className="font-semibold text-blue-950">{realisation.titre}</h3>
                                            <p className="mt-2 text-sm text-gray-600">{realisation.client}</p>
                                            <span className="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-orange-500">
                                                Voir le projet
                                                <Icon
                                                    name="arrow-right"
                                                    className="size-3.5 transition-transform group-hover:translate-x-1"
                                                />
                                            </span>
                                        </div>
                                    </Link>
                                </Reveal>
                            ))}
                        </div>
                    </div>
                </section>
            )}
        </AppLayout>
    )
}
