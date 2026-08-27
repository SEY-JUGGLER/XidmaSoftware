import { Link } from '@inertiajs/react'
import AppLayout from '../../Components/AppLayout'
import Icon from '../../Components/Icon'
import PageHero from '../../Components/PageHero'
import Reveal from '../../Components/Reveal'
import { resolveImageUrl } from '../../lib/image'

type Realisation = {
    id: number
    titre: string
    client: string
    secteur: string
    probleme: string
    solution: string
    resultats: string
    date_realisation: string
    image_cover: string | null
    service: {
        id: number
        titre: string
        slug: string
    } | null
}

const SECTIONS = [
    { key: 'probleme' as const, icon: 'target' as const, title: 'Le problème' },
    { key: 'solution' as const, icon: 'bolt' as const, title: 'Notre solution' },
    { key: 'resultats' as const, icon: 'chart-bar' as const, title: 'Les résultats' },
]

export default function RealisationShow({ realisation }: { realisation: Realisation }) {
    return (
        <AppLayout title={realisation.titre}>
            <PageHero
                eyebrow={realisation.service ? realisation.service.titre : realisation.secteur}
                title={realisation.titre}
            >
                <div className="flex flex-wrap gap-3">
                    <span className="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm text-blue-100 ring-1 ring-white/20">
                        <Icon name="users" className="size-4" />
                        {realisation.client}
                    </span>
                    <span className="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm text-blue-100 ring-1 ring-white/20">
                        {realisation.date_realisation}
                    </span>
                </div>
            </PageHero>

            {resolveImageUrl(realisation.image_cover) && (
                <section className="mx-auto max-w-4xl px-4 pt-10 sm:px-6">
                    <Reveal>
                        <img
                            src={resolveImageUrl(realisation.image_cover)!}
                            alt={realisation.titre}
                            className="aspect-video w-full rounded-2xl object-cover shadow-lg"
                            loading="lazy"
                        />
                    </Reveal>
                </section>
            )}

            <article className="mx-auto max-w-4xl px-4 py-16 sm:px-6">
                <div className="space-y-6">
                    {SECTIONS.map((section, index) => (
                        <Reveal key={section.key} delay={index * 90}>
                            <div className="flex gap-5 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                                <span className="flex size-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-blue-900 text-white">
                                    <Icon name={section.icon} className="size-5" />
                                </span>
                                <div>
                                    <h2 className="text-lg font-bold text-blue-950">{section.title}</h2>
                                    <p className="mt-2 leading-relaxed text-gray-600">{realisation[section.key]}</p>
                                </div>
                            </div>
                        </Reveal>
                    ))}
                </div>

                <Reveal delay={270} className="mt-12 rounded-2xl bg-blue-950 p-8 text-center">
                    <h2 className="text-xl font-bold text-white">Un projet similaire en tête ?</h2>
                    <p className="mt-2 text-blue-200">Parlons de vos objectifs et de la meilleure façon d’y arriver.</p>
                    <Link
                        href="/contact"
                        className="mt-6 inline-flex items-center gap-2 rounded-lg bg-orange-500 px-6 py-3 font-semibold text-white transition hover:bg-orange-400"
                    >
                        Contactez-nous
                        <Icon name="arrow-right" className="size-4" />
                    </Link>
                </Reveal>
            </article>
        </AppLayout>
    )
}
