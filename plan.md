# Plan de développement — Site web Xidma Software
## Stack : Laravel 12 + Inertia.js + React + TypeScript + Tailwind CSS

**Objet :** Site vitrine + génération de leads pour Xidma Software, cabinet de conseil en digitalisation, automatisation et transformation IT.
**Usage de ce document :** spécification technique complète + procédure d'exécution pas à pas, destinée à être suivie par un agent IA ou un développeur, de l'installation aux tests.

---

## 1. Vision & positionnement (inchangé)

**Proposition de valeur :** accompagnement de bout en bout — audit, digitalisation des processus métier, automatisation, conseil IT — pour PME, indépendants et institutions.

**Cibles :** PME/TPE, professionnels indépendants (cabinets, cliniques, commerces), administrations locales.

**Différenciateurs :** accompagnement complet (audit → dev → formation → support), solutions sur-mesure, ancrage local (contexte sénégalais/africain).

---

## 2. Arborescence du site (sitemap)

```
Public (React / Inertia pages)
/                       Accueil
/a-propos               À propos
/services               Vue d'ensemble des services
/services/{slug}        Détail service (digitalisation, automatisation, conseil-it)
/realisations           Portfolio / études de cas
/realisations/{slug}    Détail d'un projet
/blog                   Articles
/blog/{slug}            Article détaillé
/contact                Formulaire de contact
/mentions-legales
/politique-confidentialite

Admin (Filament v4 — reste en Blade/Livewire, indépendant d'Inertia)
/admin                  Dashboard, gestion services/réalisations/articles/leads/témoignages
```

> **Note d'architecture :** Filament et Inertia cohabitent très bien dans un même projet Laravel — Filament sert le back-office (routes `/admin/*`), Inertia+React sert le front public (toutes les autres routes). Aucun conflit, ce sont deux systèmes de rendu séparés dans la même app Laravel.

---

## 3. Stack technique détaillée

| Couche | Choix | Rôle |
|---|---|---|
| Backend | Laravel 12 | Routing, logique métier, API interne, validation |
| Pont frontend | Inertia.js v2 | Élimine le besoin d'une API REST séparée ; les contrôleurs Laravel renvoient directement des "pages" React |
| Frontend | React 18 + TypeScript | Composants de pages et UI |
| Build | Vite | Bundling, HMR en dev |
| Styles | Tailwind CSS v4 | Design system utilitaire |
| Formulaires | Inertia `useForm` hook | Gestion état, validation, erreurs serveur sans API manuelle |
| Admin | Filament v4 (Blade/Livewire) | CRUD back-office, indépendant du front React |
| Base de données | PostgreSQL | Cohérent avec ton setup Render existant |
| Tests backend | Pest v3 | Tests unitaires + feature Laravel |
| Tests frontend | Vitest + React Testing Library | Tests de composants React |
| Tests E2E | Playwright | Parcours utilisateur complets (formulaire de contact, navigation) |
| Emails | Laravel Mail + SMTP (Resend/Brevo) | Notification leads |
| Hébergement | Render (Web Service + PostgreSQL) | Réutilise ton setup SmartCity |

**Pourquoi Inertia plutôt que Blade pur ou une SPA découplée :**
- Pas besoin de construire/maintenir une API REST séparée (contrairement à un frontend React + API Laravel classique)
- SEO géré via SSR Inertia (rendu serveur au premier chargement, essentiel pour un site vitrine)
- Routing centralisé côté Laravel (pas de duplication de routes)
- Expérience développeur proche du "monolithe moderne" : un seul repo, un seul déploiement

---

## 4. Modèle de données (inchangé, rappel)

```
services          : titre, slug, description_courte, description_longue, icone, image, ordre_affichage, actif
realisations       : titre, slug, client, secteur, probleme, solution, resultats, image_cover, service_id (FK), publie, date_realisation
articles           : titre, slug, extrait, contenu, image_cover, categorie, statut, publie_le, meta_title, meta_description
temoignages        : nom_client, entreprise, poste, contenu, note, photo, actif
leads              : nom, email, telephone, entreprise, service_interesse_id (FK), message, source, statut
```

---

## 5. Architecture Inertia/React — structure des dossiers

```
app/
  Http/
    Controllers/
      HomeController.php
      ServiceController.php
      RealisationController.php
      ArticleController.php
      ContactController.php
    Middleware/
      HandleInertiaRequests.php   (partage des données globales : nav, meta, flash)
  Models/
    Service.php, Realisation.php, Article.php, Temoignage.php, Lead.php
  Filament/
    Resources/                   (CRUD admin, séparé du front)

resources/
  js/
    app.tsx                      (point d'entrée Inertia)
    Pages/
      Home.tsx
      About.tsx
      Services/
        Index.tsx
        Show.tsx
      Realisations/
        Index.tsx
        Show.tsx
      Blog/
        Index.tsx
        Show.tsx
      Contact.tsx
    Components/
      Layout/
        AppLayout.tsx
        Header.tsx
        Footer.tsx
      ui/
        ServiceCard.tsx
        RealisationCard.tsx
        TestimonialCard.tsx
        CtaBlock.tsx
        SeoHead.tsx
    types/
      index.ts                   (types partagés : Service, Realisation, etc.)
  css/
    app.css                      (Tailwind)

tests/
  Feature/                       (Pest — tests HTTP/Inertia responses)
  Unit/
resources/js/__tests__/          (Vitest — tests composants)
tests/e2e/                       (Playwright)
```

---

## 6. Détail des pages (inchangé dans le contenu, cf. plan précédent)

### 6.1 Accueil — sections : Hero, bandeau de confiance, problème→solution, 3 piliers services, méthodologie (timeline), études de cas, témoignages, blog, CTA final
### 6.2 Services — overview + pages détail par slug avec livrables concrets et CTA pré-rempli
### 6.3 Réalisations — liste filtrable + détail structuré problème/solution/résultats
### 6.4 Blog — liste paginée, catégories, article avec contenu riche
### 6.5 Contact — formulaire Inertia `useForm`, validation Laravel, email de notification + confirmation

*(Contenu détaillé identique au plan précédent — seule l'implémentation technique change.)*

---

## 7. Design system (inchangé)

- Palette : bleu/indigo profond (#1E3A8A) + accent orange (#F97316) + neutres
- Typographie titres : Space Grotesk / Sora / Manrope
- Typographie texte : Inter
- Style : cartes avec ombres douces, coins arrondis, mobile-first impératif

---

## 8. Procédure pas à pas — de l'installation aux tests (approche lead dev)

### Étape 1 — Initialisation du projet
```bash
composer create-project laravel/laravel xidma-software
cd xidma-software

# Installation d'Inertia + React côté Laravel (starter kit officiel)
composer require laravel/inertia   # ou via laravel/breeze --stack=react si tu veux l'auth incluse
php artisan inertia:react-starter-kit   # ou installation manuelle ci-dessous si tu pars from scratch
```

Si installation manuelle (recommandé pour un contrôle total, projet sans auth complexe) :
```bash
npm install @inertiajs/react react react-dom
npm install -D @vitejs/plugin-react typescript @types/react @types/react-dom
composer require inertiajs/inertia-laravel
php artisan inertia:middleware
```
- Enregistrer `HandleInertiaRequests` dans `bootstrap/app.php`
- Configurer `vite.config.js` avec le plugin React
- Créer `resources/js/app.tsx` comme point d'entrée Inertia

**Critère de validation :** `npm run dev` + `php artisan serve` → une page React de test s'affiche via une route Laravel.

### Étape 2 — Configuration base de données & environnement
```bash
# .env : configurer PostgreSQL
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=xidma_software
DB_USERNAME=postgres
DB_PASSWORD=...

php artisan migrate:install
```
**Critère de validation :** `php artisan migrate` s'exécute sans erreur sur une base vide.

### Étape 3 — Modèles, migrations, factories
```bash
php artisan make:model Service -mf
php artisan make:model Realisation -mf
php artisan make:model Article -mf
php artisan make:model Temoignage -mf
php artisan make:model Lead -mf
```
- Écrire les migrations selon le schéma section 4
- Écrire les factories avec des données crédibles (Faker en `fr_FR`)
- Ajouter les relations Eloquent (`Realisation belongsTo Service`, `Service hasMany Realisation`)

**Critère de validation :** `php artisan migrate:fresh --seed` peuple la base sans erreur ; `php artisan tinker` permet d'interroger les relations.

### Étape 4 — Installation Filament (admin, en parallèle)
```bash
composer require filament/filament:"^4.0"
php artisan filament:install --panels
php artisan make:filament-user
```
- Générer les Resources : `php artisan make:filament-resource Service --generate` (idem pour chaque modèle)
- Personnaliser formulaires (upload d'images via `FileUpload`, select relationnel pour `service_id`)

**Critère de validation :** connexion à `/admin`, CRUD complet fonctionnel sur chaque ressource.

### Étape 5 — Middleware Inertia & partage de données globales
Dans `HandleInertiaRequests.php`, partager :
```php
public function share(Request $request): array
{
    return [
        ...parent::share($request),
        'services_nav' => fn () => Service::actif()->orderBy('ordre_affichage')->get(['id','titre','slug']),
        'flash' => fn () => [
            'success' => $request->session()->get('success'),
        ],
    ];
}
```
**Critère de validation :** la navigation reçoit dynamiquement la liste des services sur toutes les pages sans requête dupliquée par contrôleur.

### Étape 6 — Layout & composants React de base
- `AppLayout.tsx` (header sticky, nav responsive, footer)
- `SeoHead.tsx` (gestion des balises `<title>`, meta description, OG via `@inertiajs/react`'s `Head`)
- Composants UI réutilisables : `ServiceCard`, `RealisationCard`, `TestimonialCard`, `CtaBlock`

**Critère de validation :** une page de démonstration utilise `AppLayout` et affiche correctement en desktop/mobile.

### Étape 7 — Contrôleurs + pages Inertia (par ordre de priorité business)
Ordre recommandé : **Accueil → Contact → Services → Réalisations → Blog → À propos**

Exemple contrôleur :
```php
class HomeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Home', [
            'services' => Service::actif()->orderBy('ordre_affichage')->get(),
            'realisations' => Realisation::publie()->latest('date_realisation')->take(3)->get(),
            'temoignages' => Temoignage::actif()->inRandomOrder()->take(3)->get(),
            'articles' => Article::publie()->latest('publie_le')->take(3)->get(),
        ]);
    }
}
```
**Critère de validation :** chaque page se charge avec des données réelles de la base, sans données codées en dur dans le composant React.

### Étape 8 — Formulaire de contact (Inertia `useForm`)
```tsx
const { data, setData, post, processing, errors, wasSuccessful } = useForm({
  nom: '', email: '', telephone: '', entreprise: '', service_interesse_id: '', message: ''
});

const submit = (e: FormEvent) => {
  e.preventDefault();
  post('/contact');
};
```
- Contrôleur : validation Laravel classique (`$request->validate()`), création du `Lead`, envoi des emails (`Mail::to()->send()` + notification interne), redirection avec message flash.

**Critère de validation :** soumission testée manuellement → lead visible dans `/admin/leads`, email reçu (utiliser Mailtrap ou log driver en dev).

### Étape 9 — SEO & performance
- `SeoHead` sur chaque page avec title/description dynamiques
- Génération `sitemap.xml` via une commande artisan planifiée ou un package (`spatie/laravel-sitemap`)
- Activer le SSR Inertia pour le rendu initial (`php artisan inertia:start-ssr` en prod, via `@inertiajs/react` SSR bundle)
- Compression d'images, lazy loading (`loading="lazy"` sur `<img>`)

**Critère de validation :** audit Lighthouse mobile >90 ; `view-source` d'une page publique affiche le HTML déjà rendu (preuve que le SSR fonctionne, pas juste un `<div id="app">` vide).

### Étape 10 — Tests

**Backend (Pest) :**
```bash
composer require pestphp/pest --dev --with-all-dependencies
php artisan pest:install
```
- Tests Feature : chaque route publique renvoie le bon composant Inertia (`assertInertia(fn ($page) => $page->component('Home'))`)
- Test du formulaire de contact : soumission valide crée un `Lead` en base ; soumission invalide renvoie les erreurs attendues
- Tests Unit : scopes des modèles (`actif()`, `publie()`), relations Eloquent

**Frontend (Vitest + React Testing Library) :**
```bash
npm install -D vitest @testing-library/react @testing-library/jest-dom jsdom
```
- Tests de rendu des composants `ServiceCard`, `TestimonialCard` avec props mockées
- Test du formulaire de contact : affichage des erreurs de validation, état de chargement

**E2E (Playwright) :**
```bash
npm init playwright@latest
```
- Scénario : parcours complet visiteur → accueil → clic service → page détail → contact → soumission → vérification du message de succès

**Critère de validation global :** `php artisan test`, `npm run test`, `npx playwright test` passent tous en CI avant tout déploiement.

### Étape 11 — CI/CD & déploiement Render
```yaml
# render.yaml
services:
  - type: web
    name: xidma-software
    env: php
    buildCommand: "composer install --no-dev --optimize-autoloader && npm install && npm run build && php artisan migrate --force && php artisan config:cache"
    startCommand: "php artisan serve --host 0.0.0.0 --port $PORT"
databases:
  - name: xidma-db
    plan: free
```
- Ajouter un workflow GitHub Actions qui lance les 3 suites de tests avant merge sur `main`
- Variables d'environnement de production configurées dans Render (clé app, DB, SMTP)

**Critère de validation :** déploiement réussi, site accessible en HTTPS, formulaire de contact fonctionnel en production, tests CI verts.

---

## 9. Prompts prêts à donner à l'agent IA (par étape)

**Étape 1-2 :**
> "Initialise un projet Laravel 12 avec Inertia.js v2 et React 18 en TypeScript, build via Vite. Configure la connexion PostgreSQL dans .env. Crée le middleware HandleInertiaRequests et enregistre-le dans bootstrap/app.php. Vérifie que 'npm run dev' + 'php artisan serve' affichent une page React de test rendue via Inertia."

**Étape 3 :**
> "Crée les modèles Eloquent Service, Realisation, Article, Temoignage, Lead avec leurs migrations selon ce schéma : [coller schéma section 4]. Ajoute les relations (Realisation belongsTo Service). Crée des factories avec Faker en fr_FR et un seeder avec des données réalistes pour Xidma Software (conseil en digitalisation/automatisation, contexte sénégalais)."

**Étape 4 :**
> "Installe Filament v4, crée un panel admin, génère les Filament Resources pour Service, Realisation, Article, Temoignage, Lead avec formulaires complets (upload d'images, select relationnel pour service_id) et tables avec filtres/recherche."

**Étape 5-6 :**
> "Configure le partage de données globales Inertia (navigation des services, messages flash) dans HandleInertiaRequests. Crée le layout React AppLayout.tsx (header sticky responsive, footer), le composant SeoHead.tsx utilisant le composant Head d'Inertia, et les composants UI ServiceCard, RealisationCard, TestimonialCard, CtaBlock en Tailwind CSS."

**Étape 7 :**
> "Crée les contrôleurs HomeController, ServiceController, RealisationController, ArticleController avec leurs routes web.php, chacun retournant Inertia::render() vers une page React correspondante dans resources/js/Pages/, alimentée par des données réelles depuis les modèles Eloquent (aucune donnée en dur)."

**Étape 8 :**
> "Crée le composant Contact.tsx utilisant le hook useForm d'Inertia (nom, email, telephone, entreprise, service_interesse_id, message). Crée ContactController@store avec validation Laravel, création du Lead, envoi d'un email de notification interne et d'un email de confirmation au lead via des Mailables dédiés, puis redirection avec message flash de succès."

**Étape 9 :**
> "Ajoute le SEO dynamique (title, meta description, Open Graph) via SeoHead sur toutes les pages publiques. Installe spatie/laravel-sitemap et génère sitemap.xml. Active le rendu SSR d'Inertia pour la production."

**Étape 10 :**
> "Installe Pest et écris des tests Feature vérifiant que chaque route publique retourne le bon composant Inertia, et que le formulaire de contact crée bien un Lead en base avec gestion des erreurs de validation. Installe Vitest + React Testing Library et teste le rendu de ServiceCard et du formulaire de contact. Installe Playwright et écris un test E2E du parcours accueil → service → contact → soumission réussie."

**Étape 11 :**
> "Prépare le déploiement Render avec un render.yaml définissant le Web Service PHP et la base PostgreSQL, incluant build du frontend Vite et migrations automatiques. Crée un workflow GitHub Actions exécutant les tests Pest, Vitest et Playwright avant tout merge sur main."

---

## 10. Checklist finale avant mise en ligne

- [ ] `php artisan test` (Pest) — 100% vert
- [ ] `npm run test` (Vitest) — 100% vert
- [ ] `npx playwright test` (E2E) — 100% vert
- [ ] SSR Inertia actif et vérifié (`view-source` non vide)
- [ ] Toutes les pages responsive (mobile/tablette/desktop)
- [ ] Formulaire de contact testé de bout en bout (email reçu, lead visible dans Filament)
- [ ] Admin Filament : CRUD complet fonctionnel sur les 5 ressources
- [ ] SEO : titres, meta descriptions, sitemap.xml générés
- [ ] Lighthouse mobile >90
- [ ] Aucun contenu placeholder/Lorem Ipsum restant
- [ ] Variables d'environnement production configurées sur Render
- [ ] CI GitHub Actions verte avant merge sur main
