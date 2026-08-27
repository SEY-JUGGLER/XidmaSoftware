import { Link } from '@inertiajs/react'
import AppLayout from '../../Components/AppLayout'
import Icon from '../../Components/Icon'
import PageHero from '../../Components/PageHero'
import Reveal from '../../Components/Reveal'
import { resolveImageUrl } from '../../lib/image'

type Realisation = {
    id: number
    slug: string
    titre: string
    client: string
    secteur: string
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

export default function RealisationsIndex({
    services,
    service_id,
    realisations,
}: {
    services: Array<{
        id: number
        titre: string
        slug: string
    }>
    service_id: number
    realisations: Realisation[]
}) {
    return (
        <AppLayout title="Réalisations">
            <PageHero
                eyebrow="Réalisations"
                title="Des projets qui transforment le quotidien"
                description="Quelques projets qui ont transformé le quotidien de nos clients."
            >
                <div className="flex flex-wrap gap-2">
                    <Link
                        href="/realisations"
                        className={`rounded-full px-4 py-2 text-sm font-medium transition ${
                            service_id
                                ? 'bg-white/10 text-blue-100 ring-1 ring-white/20 hover:bg-white/20'
                                : 'bg-orange-500 text-white'
                        }`}
                    >
                        Toutes
                    </Link>
                    {services.map((service) => (
                        <Link
                            key={service.id}
                            href={`/realisations?service=${service.id}`}
                            className={`rounded-full px-4 py-2 text-sm font-medium transition ${
                                service_id === service.id
                                    ? 'bg-orange-500 text-white'
                                    : 'bg-white/10 text-blue-100 ring-1 ring-white/20 hover:bg-white/20'
                            }`}
                        >
                            {service.titre}
                        </Link>
                    ))}
                </div>
            </PageHero>

            <section className="mx-auto max-w-7xl px-4 py-16 sm:px-6">
                <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    {realisations.map((realisation, index) => (
                        <Reveal key={realisation.id} delay={index * 90}>
                            <Link
                                href={`/realisations/${realisation.slug}`}
                                className="group block h-full overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-blue-900/10"
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
                                        <>
                                            <div className="bg-grid-light absolute inset-0 opacity-30" />
                                            <span className="relative text-xl font-bold text-white/90">
                                                {initials(realisation.client)}
                                            </span>
                                        </>
                                    )}
                                </div>
                                <div className="p-6">
                                    <h2 className="text-lg font-semibold text-blue-950">{realisation.titre}</h2>
                                    <p className="mt-3 text-sm text-gray-600">{realisation.client}</p>
                                    {realisation.secteur && (
                                        <span className="mt-4 inline-block rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">
                                            {realisation.secteur}
                                        </span>
                                    )}
                                </div>
                            </Link>
                        </Reveal>
                    ))}
                </div>

                {realisations.length === 0 && (
                    <div className="flex flex-col items-center gap-3 py-16 text-center">
                        <Icon name="target" className="size-10 text-blue-200" />
                        <p className="text-gray-500">Aucune réalisation pour ce filtre pour le moment.</p>
                    </div>
                )}
            </section>
        </AppLayout>
    )
}
