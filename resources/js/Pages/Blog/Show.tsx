import { Link } from '@inertiajs/react'
import AppLayout from '../../Components/AppLayout'
import Icon from '../../Components/Icon'
import Reveal from '../../Components/Reveal'

type Article = {
    id: number
    slug: string
    titre: string
    extrait: string
    contenu: string
    categorie: string
    publie_le: string
}

export default function BlogShow({
    article,
    articles_recents,
}: {
    article: Article
    articles_recents: Array<{
        id: number
        slug: string
        titre: string
        publie_le: string
    }>
}) {
    return (
        <AppLayout title={article.titre} description={article.extrait}>
            <section className="relative overflow-hidden bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800">
                <div className="bg-grid-light absolute inset-0 [mask-image:radial-gradient(ellipse_at_top,black,transparent_75%)]" />
                <div className="relative mx-auto max-w-3xl px-4 py-20 sm:px-6">
                    <span className="inline-block rounded-full bg-orange-500/90 px-3 py-1 text-xs font-medium text-white">
                        {article.categorie}
                    </span>
                    <h1 className="mt-4 text-3xl font-bold text-white md:text-4xl">{article.titre}</h1>
                    <p className="mt-3 text-sm text-blue-200">Publié le {article.publie_le}</p>
                </div>
            </section>

            <Reveal className="mx-auto max-w-3xl px-4 py-14 sm:px-6">
                <article className="leading-relaxed whitespace-pre-line text-gray-700">{article.contenu}</article>
            </Reveal>

            {articles_recents.length > 0 && (
                <section className="bg-blue-50/60 py-14">
                    <div className="mx-auto max-w-3xl px-4 sm:px-6">
                        <h2 className="text-xl font-bold text-blue-950">Articles récents</h2>
                        <div className="mt-6 grid gap-4">
                            {articles_recents.map((item, index) => (
                                <Reveal key={item.id} delay={index * 80}>
                                    <Link
                                        href={`/blog/${item.slug}`}
                                        className="group flex items-center justify-between rounded-xl border border-gray-100 bg-white p-4 transition hover:shadow-md"
                                    >
                                        <div>
                                            <h3 className="font-semibold text-blue-950">{item.titre}</h3>
                                            <p className="mt-1 text-xs text-gray-400">{item.publie_le}</p>
                                        </div>
                                        <Icon
                                            name="arrow-right"
                                            className="size-4 shrink-0 text-orange-500 transition-transform group-hover:translate-x-1"
                                        />
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
