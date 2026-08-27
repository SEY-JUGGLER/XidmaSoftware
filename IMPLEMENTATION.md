# Implementations backend — Xidma Software

> Passe 1 : couche données (migrations, modèles, factories, seeder, tests PHPUnit).
> Passe 2 : Inertia + contrôleurs publics (routes, Form Request, rate limiting, emails) + pages React.
> Application : Laravel 13.24 · PHP 8.5 · PostgreSQL.

---

## 1. Ce qui a été livré

| Zone | Fichiers |
|---|---|
| Migrations (5) | `database/migrations/2026_08_09_132140_create_services_table.php` et suivantes |
| Modèles (5) | `app/Models/{Service,Realisation,Article,Temoignage,Lead}.php` |
| Factories (5) | `database/factories/{ServiceFactory,RealisationFactory,ArticleFactory,TemoignageFactory,LeadFactory}.php` |
| Seeder | `database/seeders/DatabaseSeeder.php` |
| Tests (3 classes, 11 tests) | `tests/Feature/{ScopesTest,RelationsTest,ModelGuardingTest}.php` |
| Locale Faker | `.env` / `.env.example` : `APP_FAKER_LOCALE=fr_FR` |
| Routage + Inertia | `routes/web.php`, `app/Http/Middleware/HandleInertiaRequests.php`, `resources/views/app.blade.php` |
| Contrôleurs | `app/Http/Controllers/{HomeController,ServiceController,RealisationController,ArticleController,ContactController}.php` |
| Validation | `app/Http/Requests/StoreContactRequest.php` (Form Request + honeypot) |
| Emails | `app/Mail/{NouveauContact,ConfirmationContact}.php` + `resources/views/mail/*.blade.php` |
| Rate limiting | `app/Providers/AppServiceProvider.php` (`contact-form` : 3/min/IP) |
| Frontend React | `resources/js/app.tsx`, `Components/AppLayout.tsx`, `Pages/{Home,Contact,Services/*,Realisations/*,Blog/*}.tsx` |

---

## 2. Schéma de données (conforme plan.md §4)

| Table | Colonnes (résumé) |
|---|---|
| `services` | titre, slug (unique), description_courte, description_longue, icone, image (null), ordre_affichage (défaut 0), actif (bool, défaut true) |
| `realisations` | titre, slug (unique), client, secteur, probleme, solution, resultats, image_cover (null), service_id (FK → services, restrictOnDelete), date_realisation, publie (bool, défaut false) |
| `articles` | titre, slug (unique), extrait, contenu, image_cover (null), categorie, statut (bool, défaut false), publie_le (null), meta_title (null), meta_description (null) |
| `temoignages` | nom_client, entreprise, poste (null), contenu, note (défaut 5), photo (null), actif (bool, défaut true) |
| `leads` | nom, email, telephone (null), entreprise (null), service_interesse_id (FK → services, nullOnDelete), message (null), source (défaut "web"), statut (défaut "nouveau") |

---

## 3. Modèles — sécurité & conventions

- **Protection mass-assignment** : `#[Fillable(...)]` sur chaque modèle (whitelist). Aucun `$guarded = []`.
- **Casts** : booléens (`actif`, `publie`, `statut`), `date` (`date_realisation`), `datetime` (`publie_le`), `integer` (`ordre_affichage`, `note`).
- **Scopes locaux** (opt-in, pas de scope global) :
  - `Service::actif()`
  - `Realisation::publie()`
  - `Article::publie()`
  - `Temoignage::actif()`
- **Relations** : `Service::realisations()` (hasMany), `Realisation::service()` (belongsTo), `Lead::serviceInteresse()` (belongsTo via `service_interesse_id`).

---

## 4. Factories & seeder

- Faker en `fr_FR`.
- États factories : `Service::inactif()`, `Realisation::nonPubliee()`, `Article::brouillon()`, `Lead::sansService()`, `Temoignage::inactif()`.
- Seeder : 4 services métier réalistes (Digitalisation, Automatisation, Conseil IT, Support), réalisations/notes 3 par service + 2 brouillons, 9 articles + 2 brouillons, 6 témoignages + 1 inactif, 7 leads.

---

## 5. Endpoints publics (Inertia)

Chaque contrôleur rend une page React (composant Inertia) ; aucune donnée brute n'est exposée. Les pages sont dans `resources/js/Pages/…`.

| Méthode | URL | Composant | Props partagées |
|---|---|---|---|
| GET | `/` | `Home` | `services`, `realisations` (3), `temoignages` (3), `articles` (3) |
| GET | `/services` | `Services/Index` | `services` (actifs, ordonnés) |
| GET | `/services/{service:slug}` | `Services/Show` | `service`, `realisations` (du service, publiées) — 404 si inactif |
| GET | `/realisations` | `Realisations/Index` | `services`, `service_id` (filtre `?service=`), `realisations` (publiées) |
| GET | `/realisations/{realisation:slug}` | `Realisations/Show` | `realisation` (avec `service`) — 404 si non publiée |
| GET | `/blog` | `Blog/Index` | `categories`, `categorie` (filtre `?categorie=`), `articles` (paginate 9) |
| GET | `/blog/{article:slug}` | `Blog/Show` | `article`, `articles_recents` (3) — 404 si brouillon |
| GET | `/contact` | `Contact` | `services` (actifs : `id`, `titre`) |
| POST | `/contact` | — (redirect back + flash `success`) | validation, honeypot, throttle, emails |

Toutes les pages sont accessibles sans authentification. La racine Inertia est `resources/views/app.blade.php` (avec `@vite`).

### Flux du formulaire de contact

1. **Validation** (`StoreContactRequest`) : `nom`/`email` requis, `telephone`/`entreprise`/`message` optionnels (`message` max 5000), `service_interesse_id` nullable + `exists:services,id`.
2. **Honeypot** : champ caché `website` — s'il est rempli, réponse de succès factice sans créer de lead (anti-bot).
3. **Rate limiting** : middleware `throttle:contact-form` (3 requêtes/minute par IP).
4. **Stockage** : `Lead::create($request->validated())` (whitelist, source "web", statut "nouveau").
5. **Emails (queue)** : `NouveauContact` → adresse `MAIL_FROM_ADDRESS` ; `ConfirmationContact` → email du lead. Les deux `ShouldQueue` + `afterCommit()`.

---

## 6. Tests

```
php artisan test --compact            # tout passe (30 tests)
```

- `ScopesTest` : filtres `actif` / `publie` / brouillons.
- `RelationsTest` : hasMany / belongsTo / lead sans service.
- `ModelGuardingTest` : les champs non-fillable sont rejetés.
- `PublicPagesTest` : chaque route rend bien son composant Inertia, les requêtes par slug résolvent, et les contenus non publiés/inactifs renvoient 404.
- `ContactFlowTest` : création du lead, honeypot (pas de création mais réponse de succès), envoi des deux emails, validation des erreurs, throttling.
- `LazilyRefreshDatabase` : migrations rejouées par test sur une base SQLite en mémoire (les tests n'utilisent ni PostgreSQL ni le seeder).

---

## 7. Sécurité — décisions prises

- **Sécurité par défaut** : whitelist `fillable` partout, aucune insertion depuis `$request->all()`.
- **Intégrité référentielle** : FK avec `constrained()`, `restrictOnDelete` (ne pas voir de réelisation orpheline), `nullOnDelete` pour lead.service_interesse_id.
- **Pas de secret en code** : aucune dépendance ajoutée ; `.env` reste git-ignoré.
- **Formulaire de contact durci** : Form Request (`validated()` uniquement), honeypot `website`, throttle `contact-form` (3/min/IP), emails en file d'attente.
- **404 sur le contenu masqué** : les services inactifs, réalisations non publiées et articles brouillons renvoient 404 (pas d'exposition).
- **Secrets** : clé APP_KEY, DB et MAIL dans `.env` (git-ignoré). Penser `APP_DEBUG=false` + `APP_ENV=production` en prod.

---

## 8. Notes importantes

- **Version** : l'installation réelle est **Laravel 13.24** (le `plan.md` cible Laravel 12) — le code suit la version installée.
- **Engine** : PostgreSQL (`xidma_Software`), migré et seedé avec succès : 11 services, 14 réalisations, 11 articles, 7 témoignages, 7 leads.
- **Frontend** : Inertia v3 (`inertiajs/inertia-laravel` 3.3.1) + React 19 + TypeScript 7 + Tailwind v4, assemblé par Vite. PS : TypeScript 7 a supprimé `baseUrl` → `tsconfig.json` utilise uniquement `paths`.
- **Tests via factory** : les factories Laravel passent par `Model::unguarded()` — la protection fillable se teste donc via `new Model([...])`.
- **Manifest Vite** : `assertInertia` exige un manifest ; un `npm run build` (ou `npm run dev`) doit avoir été exécuté avant les tests de pages.
- **Factory Realisation** : crée son propre `Service` par défaut → dans les tests, penser à fixer `service_id` si le nombre de services compté importe.

---

## 9. Connecter le frontend React au backend

Le front est monté sur le même serveur Laravel via Inertia. Pour le développer :

```
npm run dev                      # serveur Vite (HMR) dans un terminal
php artisan serve                # ou : composer run dev (que l'utilisateur peut lancer)
```

- **Pages** : créées dans `resources/js/Pages/`, une par composant Inertia. Leur nom (`Home`, `Services/Index`, …) correspond exactement au `Inertia::render('…')` des contrôleurs.
- **Fichiers** : `resources/js/app.tsx` (bootstrap `createInertiaApp`), `resources/js/Components/AppLayout.tsx` (nav/footer communs), `tsconfig.json` (alias `@/*` → `resources/js/*`).
- **Prop typées** : chaque page reçoit les props listées en §5. Les typer explicitement (comme dans les pages existantes) — le serveur n'expose que les colonnes `fillable` (whitelist).
- **Navigation** : utiliser des liens normaux (les pages existantes utilisent `href`) ; Inertia fait les navigations « côté client ».
- **Formulaire contact** : la page `Contact.tsx` utilise `useForm` (`post('/contact', { preserveScroll: true })`). Les erreurs de validation arrivent dans `errors.*`, le succès via la prop partagée `flash.success` (cf. `HandleInertiaRequests`).
- **Filtres** : `Realisations/Index` et `Blog/Index` lisent respectivement `?service=` et `?categorie=` (déjà gérés par les contrôleurs).
- **Pagination** : `Blog/Index` reçoit un paginateur (champs `data`, `current_page`, `last_page`, `prev_page_url`, `next_page_url`, `total`) — sérialisé par Inertia/Laravel.
- **SEO** : `AppLayout` met à jour `document.title` et `meta[name="description"]` via `@inertiaHead` ; utiliser les props `title`/`description` de chaque page.

---

## 10. Roadmap restante

1. Filament v4 pour l'admin (CRUD ressources services/réalisations/articles/témoignages/leads).
2. Pages légales (mentions légales, politique de confidentialité) liées au footer.
3. Sitemap + SEO, tests frontend, CI.
4. Production : configurer le queue worker pour les emails, `APP_DEBUG=false`.