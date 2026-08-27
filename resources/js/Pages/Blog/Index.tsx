import { Link } from '@inertiajs/react'
import AppLayout from '../../Components/AppLayout'
import Icon from '../../Components/Icon'
import PageHero from '../../Components/PageHero'
import Reveal from '../../Components/Reveal'

type Article = {
    id: number
    slug: string
    titre: string
    extrait: string
    categorie: string
    publie_le: string
}

export default function BlogIndex({
    categories,
    categorie,
    articles,
}: {
    categories: string[]
    categorie: string
    articles: {
        data: Article[]
        current_page: number
        last_page: number
        prev_page_url: string | null
        next_page_url: string | null
        total: number
    }
}) {
    return (
        <AppLayout title="Blog">
            <PageHero
                eyebrow="Blog"
                title="Nos conseils pour digitaliser votre activité"
                description="Nos conseils pour digitaliser, automatiser et sécuriser votre activité."
            >
                <div className="flex flex-wrap gap-2">
                    <Link
                        href="/blog"
                        className={`rounded-full px-4 py-2 text-sm font-medium transition ${
                            categorie
                                ? 'bg-white/10 text-blue-100 ring-1 ring-white/20 hover:bg-white/20'
                                : 'bg-orange-500 text-white'
                        }`}
                    >
                        Toutes
                    </Link>
                    {categories.map((item) => (
                        <Link
                            key={item}
                            href={`/blog?categorie=${encodeURIComponent(item)}`}
                            className={`rounded-full px-4 py-2 text-sm font-medium transition ${
                                categorie === item
                                    ? 'bg-orange-500 text-white'
                                    : 'bg-white/10 text-blue-100 ring-1 ring-white/20 hover:bg-white/20'
                            }`}
                        >
                            {item}
                        </Link>
                    ))}
                </div>
            </PageHero>

            <section className="mx-auto max-w-7xl px-4 py-16 sm:px-6">
                <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    {articles.data.map((article, index) => (
                        <Reveal key={article.id} delay={index * 90}>
                            <Link
                                href={`/blog/${article.slug}`}
                                className="group flex h-full flex-col rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-blue-900/10"
                            >
                                <span className="inline-block w-fit rounded-full bg-orange-100 px-3 py-1 text-xs font-medium text-orange-600">
                                    {article.categorie}
                                </span>
                                <h2 className="mt-4 text-lg font-semibold text-blue-950">{article.titre}</h2>
                                <p className="mt-3 flex-1 text-sm leading-relaxed text-gray-600">{article.extrait}</p>
                                <p className="mt-4 text-xs text-gray-400">{article.publie_le}</p>
                            </Link>
                        </Reveal>
                    ))}
                </div>

                {articles.data.length === 0 && (
                    <div className="flex flex-col items-center gap-3 py-16 text-center">
                        <Icon name="chat" className="size-10 text-blue-200" />
                        <p className="text-gray-500">Aucun article pour cette catégorie pour le moment.</p>
                    </div>
                )}

                {articles.last_page > 1 && (
                    <div className="mt-12 flex items-center justify-center gap-4">
                        {articles.prev_page_url ? (
                            <Link
                                href={articles.prev_page_url}
                                className="rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-600 transition hover:border-blue-300 hover:text-blue-900"
                            >
                                ← Précédent
                            </Link>
                        ) : (
                            <span className="rounded-lg border border-gray-100 px-4 py-2 text-sm font-medium text-gray-300">
                                ← Précédent
                            </span>
                        )}
                        <span className="text-sm text-gray-500">
                            Page {articles.current_page} sur {articles.last_page}
                        </span>
                        {articles.next_page_url ? (
                            <Link
                                href={articles.next_page_url}
                                className="rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-600 transition hover:border-blue-300 hover:text-blue-900"
                            >
                                Suivant →
                            </Link>
                        ) : (
                            <span className="rounded-lg border border-gray-100 px-4 py-2 text-sm font-medium text-gray-300">
                                Suivant →
                            </span>
                        )}
                    </div>
                )}
            </section>
        </AppLayout>
    )
}
