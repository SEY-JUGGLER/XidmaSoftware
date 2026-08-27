import { useForm } from '@inertiajs/react'
import { useState, type FormEvent } from 'react'
import AppLayout from '../Components/AppLayout'
import Icon from '../Components/Icon'
import Reveal from '../Components/Reveal'

const HIGHLIGHTS = [
    { icon: 'chat' as const, title: 'Échange gratuit', text: 'On discute de vos besoins sans engagement.' },
    { icon: 'rocket' as const, title: 'Réponse rapide', text: 'Un accusé de réception et un premier retour sous peu.' },
    { icon: 'shield-check' as const, title: 'Accompagnement sur-mesure', text: 'Une solution adaptée à votre taille et votre budget.' },
]

const inputClasses =
    'mt-1.5 w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-gray-900 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10'

export default function Contact({
    services,
}: {
    services: Array<{ id: number; titre: string }>
}) {
    const [website, setWebsite] = useState('')

    const { data, setData, post, processing, errors, recentlySuccessful } = useForm({
        nom: '',
        email: '',
        telephone: '',
        entreprise: '',
        service_interesse_id: '',
        message: '',
    })

    function submit(e: FormEvent<HTMLFormElement>) {
        e.preventDefault()
        post('/contact', { preserveScroll: true })
    }

    return (
        <AppLayout title="Contact">
            <section className="relative overflow-hidden bg-gradient-to-br from-blue-950 via-blue-900 to-blue-700">
                <div className="bg-grid-light absolute inset-0 [mask-image:radial-gradient(ellipse_at_top,black,transparent_70%)]" />
                <div
                    className="animate-float-slow absolute -top-24 right-10 h-72 w-72 rounded-full bg-sky-400/20 blur-3xl"
                    aria-hidden="true"
                />

                <div className="relative mx-auto grid max-w-7xl gap-12 px-4 py-20 sm:px-6 lg:grid-cols-2 lg:py-24">
                    <Reveal>
                        <p className="text-sm font-semibold tracking-wide text-orange-400 uppercase">Contact</p>
                        <h1 className="mt-3 text-4xl font-bold text-white md:text-5xl">Parlons de votre projet</h1>
                        <p className="mt-5 max-w-md text-lg text-blue-100">
                            Un projet de digitalisation, d’automatisation ou de conseil ? Racontez-nous où vous en
                            êtes, on vous recontacte rapidement.
                        </p>

                        <div className="mt-10 space-y-6">
                            {HIGHLIGHTS.map((item) => (
                                <div key={item.title} className="flex items-start gap-4">
                                    <span className="flex size-11 shrink-0 items-center justify-center rounded-xl bg-white/10 text-sky-300 ring-1 ring-white/15">
                                        <Icon name={item.icon} className="size-5" />
                                    </span>
                                    <div>
                                        <p className="font-semibold text-white">{item.title}</p>
                                        <p className="mt-0.5 text-sm text-blue-200">{item.text}</p>
                                    </div>
                                </div>
                            ))}
                        </div>

                        <a
                            href="mailto:contact@xidma-software.sn"
                            className="mt-10 inline-flex items-center gap-2 text-sm font-medium text-blue-100 hover:text-white"
                        >
                            <Icon name="mail" className="size-4" />
                            contact@xidma-software.sn
                        </a>
                    </Reveal>

                    <Reveal delay={120}>
                        <div className="rounded-2xl bg-white p-6 shadow-2xl sm:p-8">
                            {recentlySuccessful && (
                                <div className="mb-6 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                                    <Icon name="check-circle" className="size-5 shrink-0 text-green-600" />
                                    Votre message a bien été envoyé. Nous vous recontacterons rapidement.
                                </div>
                            )}

                            <form onSubmit={submit} className="space-y-5">
                                <div aria-hidden="true" className="hidden">
                                    <label htmlFor="website">Ne pas remplir ce champ</label>
                                    <input
                                        id="website"
                                        type="text"
                                        name="website"
                                        value={website}
                                        onChange={(e) => setWebsite(e.target.value)}
                                        tabIndex={-1}
                                        autoComplete="off"
                                    />
                                </div>

                                <div className="grid gap-5 sm:grid-cols-2">
                                    <div>
                                        <label htmlFor="nom" className="block text-sm font-medium text-gray-700">
                                            Nom complet *
                                        </label>
                                        <input
                                            id="nom"
                                            type="text"
                                            value={data.nom}
                                            onChange={(e) => setData('nom', e.target.value)}
                                            className={inputClasses}
                                        />
                                        {errors.nom && <p className="mt-1.5 text-sm text-red-600">{errors.nom}</p>}
                                    </div>

                                    <div>
                                        <label htmlFor="email" className="block text-sm font-medium text-gray-700">
                                            Adresse email *
                                        </label>
                                        <input
                                            id="email"
                                            type="email"
                                            value={data.email}
                                            onChange={(e) => setData('email', e.target.value)}
                                            className={inputClasses}
                                        />
                                        {errors.email && <p className="mt-1.5 text-sm text-red-600">{errors.email}</p>}
                                    </div>
                                </div>

                                <div className="grid gap-5 sm:grid-cols-2">
                                    <div>
                                        <label htmlFor="telephone" className="block text-sm font-medium text-gray-700">
                                            Téléphone
                                        </label>
                                        <input
                                            id="telephone"
                                            type="text"
                                            value={data.telephone}
                                            onChange={(e) => setData('telephone', e.target.value)}
                                            className={inputClasses}
                                        />
                                        {errors.telephone && (
                                            <p className="mt-1.5 text-sm text-red-600">{errors.telephone}</p>
                                        )}
                                    </div>

                                    <div>
                                        <label htmlFor="entreprise" className="block text-sm font-medium text-gray-700">
                                            Entreprise
                                        </label>
                                        <input
                                            id="entreprise"
                                            type="text"
                                            value={data.entreprise}
                                            onChange={(e) => setData('entreprise', e.target.value)}
                                            className={inputClasses}
                                        />
                                        {errors.entreprise && (
                                            <p className="mt-1.5 text-sm text-red-600">{errors.entreprise}</p>
                                        )}
                                    </div>
                                </div>

                                <div>
                                    <label
                                        htmlFor="service_interesse_id"
                                        className="block text-sm font-medium text-gray-700"
                                    >
                                        Service concerné
                                    </label>
                                    <select
                                        id="service_interesse_id"
                                        value={data.service_interesse_id}
                                        onChange={(e) => setData('service_interesse_id', e.target.value)}
                                        className={inputClasses}
                                    >
                                        <option value="">— Sélectionner un service —</option>
                                        {services.map((service) => (
                                            <option key={service.id} value={service.id}>
                                                {service.titre}
                                            </option>
                                        ))}
                                    </select>
                                    {errors.service_interesse_id && (
                                        <p className="mt-1.5 text-sm text-red-600">{errors.service_interesse_id}</p>
                                    )}
                                </div>

                                <div>
                                    <label htmlFor="message" className="block text-sm font-medium text-gray-700">
                                        Votre message
                                    </label>
                                    <textarea
                                        id="message"
                                        rows={5}
                                        value={data.message}
                                        onChange={(e) => setData('message', e.target.value)}
                                        className={inputClasses}
                                    />
                                    {errors.message && <p className="mt-1.5 text-sm text-red-600">{errors.message}</p>}
                                </div>

                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="flex w-full items-center justify-center gap-2 rounded-xl bg-orange-500 px-8 py-3.5 font-semibold text-white shadow-lg shadow-orange-950/20 transition hover:bg-orange-400 disabled:cursor-not-allowed disabled:opacity-50"
                                >
                                    {processing ? 'Envoi en cours…' : 'Envoyer'}
                                    {!processing && <Icon name="arrow-right" className="size-4" />}
                                </button>
                            </form>
                        </div>
                    </Reveal>
                </div>
            </section>
        </AppLayout>
    )
}
