import { Link } from '@inertiajs/react'
import AppLayout from '../Components/AppLayout'
import Icon, { type IconName } from '../Components/Icon'
import Reveal from '../Components/Reveal'
import { resolveImageUrl } from '../lib/image'

type Service = {
    id: number
    slug: string
    titre: string
    description_courte: string
    icone?: string | null
    image?: string | null
}

type Realisation = {
    id: number
    slug: string
    titre: string
    client: string
    image_cover?: string | null
}

type Temoignage = {
    id: number
    nom_client: string
    entreprise: string
    contenu: string
}

type Article = {
    id: number
    slug: string
    titre: string
    extrait: string
    categorie: string
}

type Props = {
    services: Service[]
    realisations: Realisation[]
    temoignages: Temoignage[]
    articles?: Article[]
}

const PROCESS_STEPS = [
    {
        icon: 'target' as IconName,
        title: 'Échange & diagnostic',
        text: 'On analyse vos processus actuels et vos objectifs pour cerner les priorités.',
    },
    {
        icon: 'cog' as IconName,
        title: 'Conception',
        text: 'Nous concevons une solution sur-mesure, adaptée à votre taille et votre budget.',
    },
    {
        icon: 'rocket' as IconName,
        title: 'Déploiement',
        text: 'Mise en place progressive avec formation de vos équipes, sans rupture d’activité.',
    },
    {
        icon: 'shield-check' as IconName,
        title: 'Accompagnement',
        text: 'Support continu, supervision et amélioration au fil de votre croissance.',
    },
]

function initials(name: string): string {
    return name
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((part) => part[0]?.toUpperCase())
        .join('')
}

export default function Home({ services, realisations, temoignages, articles = [] }: Props) {
    return (
        <AppLayout title="Accueil">
            <section className="relative overflow-hidden bg-gradient-to-br from-blue-950 via-blue-900 to-blue-700">
                <div className="bg-grid-light absolute inset-0 [mask-image:radial-gradient(ellipse_at_top,black,transparent_70%)]" />
                <div
                    className="animate-float-slow absolute -top-32 -right-16 h-96 w-96 rounded-full bg-sky-400/25 blur-3xl"
                    aria-hidden="true"
                />
                <div
                    className="animate-float absolute -bottom-24 -left-16 h-80 w-80 rounded-full bg-orange-400/15 blur-3xl"
                    aria-hidden="true"
                />

                <div className="relative mx-auto grid max-w-7xl items-center gap-12 px-4 py-24 sm:px-6 lg:grid-cols-2 lg:py-32">
                    <div className="animate-fade-up text-center lg:text-left">
                        <span className="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm font-medium text-blue-100 ring-1 ring-white/20">
                            <Icon name="sparkles" className="size-4 text-orange-400" />
                            Conseil · Digitalisation · Automatisation
                        </span>
                        <h1 className="mt-6 text-4xl leading-tight font-bold text-white sm:text-5xl lg:text-6xl">
                            Faites entrer votre activité dans{' '}
                            <span className="bg-gradient-to-r from-sky-300 to-blue-100 bg-clip-text text-transparent">
                                l’ère numérique
                            </span>
                        </h1>
                        <p className="mx-auto mt-6 max-w-xl text-lg text-blue-100 lg:mx-0">
                            Xidma Software accompagne les PME, indépendants et institutions dans leur transformation
                            IT : de l’audit à la mise en production.
                        </p>
                        <div className="mt-9 flex flex-col justify-center gap-4 sm:flex-row lg:justify-start">
                            <Link
                                href="/contact"
                                className="group inline-flex items-center justify-center gap-2 rounded-lg bg-orange-500 px-8 py-3.5 font-semibold text-white shadow-lg shadow-orange-950/30 transition hover:bg-orange-400"
                            >
                                Discutons de votre projet
                                <Icon
                                    name="arrow-right"
                                    className="size-4 transition-transform group-hover:translate-x-1"
                                />
                            </Link>
                            <Link
                                href="/services"
                                className="inline-flex items-center justify-center gap-2 rounded-lg bg-white/10 px-8 py-3.5 font-semibold text-white ring-1 ring-white/25 backdrop-blur transition hover:bg-white/20"
                            >
                                Voir nos services
                            </Link>
                        </div>
                    </div>

                    <div className="animate-fade-up hidden lg:block" style={{ animationDelay: '150ms' }}>
                        <div className="relative rounded-2xl border border-white/15 bg-white/10 p-6 shadow-2xl backdrop-blur-md">
                            <div className="flex items-center gap-2">
                                <span className="size-3 rounded-full bg-orange-400" />
                                <span className="size-3 rounded-full bg-sky-300" />
                                <span className="size-3 rounded-full bg-blue-200" />
                            </div>
                            <div className="mt-6 space-y-4">
                                <div className="flex items-end gap-2">
                                    {[40, 70, 55, 90, 65].map((height, index) => (
                                        <div
                                            key={index}
                                            className="flex-1 rounded-t-md bg-gradient-to-t from-sky-400 to-blue-200"
                                            style={{ height: `${height}px` }}
                                        />
                                    ))}
                                </div>
                                <div className="grid grid-cols-2 gap-4">
                                    <div className="rounded-xl bg-white/10 p-4 ring-1 ring-white/10">
                                        <Icon name="check-circle" className="size-5 text-sky-300" />
                                        <p className="mt-3 text-sm font-medium text-white">Processus automatisés</p>
                                    </div>
                                    <div className="rounded-xl bg-white/10 p-4 ring-1 ring-white/10">
                                        <Icon name="shield-check" className="size-5 text-sky-300" />
                                        <p className="mt-3 text-sm font-medium text-white">Suivi sécurisé</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {services.length > 0 && (
                <section className="mx-auto max-w-7xl px-4 py-20 sm:px-6">
                    <Reveal className="flex flex-col items-center gap-4 text-center">
                        <p className="text-sm font-semibold tracking-wide text-blue-600 uppercase">Nos services</p>
                        <h2 className="text-3xl font-bold text-blue-950 md:text-4xl">Ce que nous faisons pour vous</h2>
                        <p className="max-w-2xl text-gray-600">
                            Un accompagnement complet, de la digitalisation à la maintenance continue.
                        </p>
                    </Reveal>

                    <div className="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                        {services.map((service, index) => {
                            const image = resolveImageUrl(service.image)

                            return (
                            <Reveal key={service.id} delay={index * 90}>
                                <Link
                                    href={`/services/${service.slug}`}
                                    className="group flex h-full flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1.5 hover:border-blue-100 hover:shadow-xl hover:shadow-blue-900/10"
                                >
                                    {image && (
                                        <div className="h-32 overflow-hidden">
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
                                        <Icon name={(service.icone as IconName) ?? 'sparkles'} className="size-6" />
                                    </span>
                                    <h3 className="mt-5 font-semibold text-blue-950">{service.titre}</h3>
                                    <p className="mt-2 flex-1 text-sm leading-relaxed text-gray-600">
                                        {service.description_courte}
                                    </p>
                                    <span className="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-orange-500">
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
            )}

            <section className="bg-blue-50/60 py-20">
                <div className="mx-auto max-w-7xl px-4 sm:px-6">
                    <Reveal className="flex flex-col items-center gap-4 text-center">
                        <p className="text-sm font-semibold tracking-wide text-blue-600 uppercase">Notre méthode</p>
                        <h2 className="text-3xl font-bold text-blue-950 md:text-4xl">Comment nous travaillons</h2>
                    </Reveal>

                    <div className="relative mt-14 grid gap-8 md:grid-cols-4">
                        <div className="absolute top-7 right-0 left-0 hidden h-px bg-gradient-to-r from-transparent via-blue-200 to-transparent md:block" />
                        {PROCESS_STEPS.map((step, index) => (
                            <Reveal key={step.title} delay={index * 100} className="relative text-center">
                                <div className="relative mx-auto flex size-14 items-center justify-center rounded-full bg-white text-blue-700 shadow-md ring-4 ring-blue-50">
                                    <Icon name={step.icon} className="size-6" />
                                </div>
                                <h3 className="mt-5 font-semibold text-blue-950">{step.title}</h3>
                                <p className="mt-2 text-sm leading-relaxed text-gray-600">{step.text}</p>
                            </Reveal>
                        ))}
                    </div>
                </div>
            </section>

            {realisations.length > 0 && (
                <section className="mx-auto max-w-7xl px-4 py-20 sm:px-6">
                    <Reveal className="flex flex-col items-center gap-4 text-center">
                        <p className="text-sm font-semibold tracking-wide text-blue-600 uppercase">Réalisations</p>
                        <h2 className="text-3xl font-bold text-blue-950 md:text-4xl">Nos derniers projets</h2>
                    </Reveal>

                    <div className="mt-12 grid gap-6 md:grid-cols-3">
                        {realisations.map((realisation, index) => (
                            <Reveal key={realisation.id} delay={index * 100}>
                                <Link
                                    href={`/realisations/${realisation.slug}`}
                                    className="group block overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-blue-900/10"
                                >
                                    <div className="relative flex h-32 items-center justify-center overflow-hidden bg-gradient-to-br from-blue-800 via-blue-700 to-sky-500">
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
                                                <span className="relative text-2xl font-bold text-white/90">
                                                    {initials(realisation.client)}
                                                </span>
                                            </>
                                        )}
                                    </div>
                                    <div className="p-6">
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
                </section>
            )}

            {temoignages.length > 0 && (
                <section className="bg-blue-950 py-20">
                    <div className="mx-auto max-w-7xl px-4 sm:px-6">
                        <Reveal className="flex flex-col items-center gap-4 text-center">
                            <p className="text-sm font-semibold tracking-wide text-sky-300 uppercase">Témoignages</p>
                            <h2 className="text-3xl font-bold text-white md:text-4xl">Ils nous font confiance</h2>
                        </Reveal>

                        <div className="mt-12 grid gap-6 md:grid-cols-3">
                            {temoignages.map((temoignage, index) => (
                                <Reveal key={temoignage.id} delay={index * 100}>
                                    <blockquote className="flex h-full flex-col rounded-2xl bg-white/5 p-6 ring-1 ring-white/10">
                                        <Icon name="chat" className="size-6 text-sky-400" />
                                        <p className="mt-4 flex-1 leading-relaxed text-blue-100">
                                            «&nbsp;{temoignage.contenu}&nbsp;»
                                        </p>
                                        <footer className="mt-6 flex items-center gap-3">
                                            <span className="flex size-10 items-center justify-center rounded-full bg-gradient-to-br from-sky-400 to-blue-600 text-sm font-semibold text-white">
                                                {initials(temoignage.nom_client)}
                                            </span>
                                            <div>
                                                <p className="text-sm font-semibold text-white">
                                                    {temoignage.nom_client}
                                                </p>
                                                <p className="text-xs text-blue-300">{temoignage.entreprise}</p>
                                            </div>
                                        </footer>
                                    </blockquote>
                                </Reveal>
                            ))}
                        </div>
                    </div>
                </section>
            )}

            {articles.length > 0 && (
                <section className="mx-auto max-w-7xl px-4 py-20 sm:px-6">
                    <Reveal className="flex flex-col items-center gap-4 text-center">
                        <p className="text-sm font-semibold tracking-wide text-blue-600 uppercase">Blog</p>
                        <h2 className="text-3xl font-bold text-blue-950 md:text-4xl">Derniers articles</h2>
                    </Reveal>

                    <div className="mt-12 grid gap-6 md:grid-cols-3">
                        {articles.map((article, index) => (
                            <Reveal key={article.id} delay={index * 100}>
                                <Link
                                    href={`/blog/${article.slug}`}
                                    className="group flex h-full flex-col rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-blue-900/10"
                                >
                                    <span className="inline-block w-fit rounded-full bg-orange-100 px-3 py-1 text-xs font-medium text-orange-600">
                                        {article.categorie}
                                    </span>
                                    <h3 className="mt-4 font-semibold text-blue-950">{article.titre}</h3>
                                    <p className="mt-2 flex-1 text-sm leading-relaxed text-gray-600">
                                        {article.extrait}
                                    </p>
                                    <span className="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-orange-500">
                                        Lire l’article
                                        <Icon
                                            name="arrow-right"
                                            className="size-3.5 transition-transform group-hover:translate-x-1"
                                        />
                                    </span>
                                </Link>
                            </Reveal>
                        ))}
                    </div>
                </section>
            )}

            <section className="mx-auto max-w-7xl px-4 pb-20 sm:px-6">
                <Reveal className="relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-900 to-blue-950 px-8 py-16 text-center sm:px-16">
                    <div
                        className="animate-float-slow absolute -top-16 right-10 h-56 w-56 rounded-full bg-sky-400/20 blur-3xl"
                        aria-hidden="true"
                    />
                    <h2 className="relative text-3xl font-bold text-white md:text-4xl">
                        Prêt à transformer votre activité ?
                    </h2>
                    <p className="relative mx-auto mt-4 max-w-xl text-blue-100">
                        Parlons de vos objectifs et construisons ensemble la feuille de route de votre transformation
                        numérique.
                    </p>
                    <Link
                        href="/contact"
                        className="relative mt-8 inline-flex items-center gap-2 rounded-lg bg-orange-500 px-8 py-3.5 font-semibold text-white shadow-lg shadow-orange-950/30 transition hover:bg-orange-400"
                    >
                        Contactez-nous
                        <Icon name="arrow-right" className="size-4" />
                    </Link>
                </Reveal>
            </section>
        </AppLayout>
    )
}
