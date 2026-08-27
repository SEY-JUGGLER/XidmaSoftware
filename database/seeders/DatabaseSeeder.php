<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Lead;
use App\Models\Realisation;
use App\Models\Service;
use App\Models\Temoignage;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->resetTestData();

        User::updateOrCreate(
            ['email' => 'admin@xidma-software.sn'],
            [
                'name' => 'Administrateur Xidma',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );

        $services = collect([
            [
                'titre' => 'Digitalisation des processus métier',
                'description_courte' => 'Numérisez vos opérations internes : gestion documentaire, facturation, flux de travail.',
                'description_longue' => 'Xidma Software audite vos processus existants et les digitalise de bout en bout : dématérialisation des documents, gestion électronique des courriers, facturation automatisée et suivi des flux de travail. Vous gagnez en traçabilité, en rapidité et en visibilité sur votre activité.',
                'icone' => 'computer-desktop',
            ],
            [
                'titre' => 'Automatisation des tâches',
                'description_courte' => 'Éliminez les tâches répétitives grâce à des automatismes fiables et sécurisés.',
                'description_longue' => 'Nous identifions les tâches répétitives qui vous font perdre du temps et les remplaçons par des automatismes : relances clients, planification de rapports, synchronisation d’outils, rapprochement bancaire. Vos équipes se concentrent enfin sur des tâches à forte valeur ajoutée.',
                'icone' => 'bolt',
            ],
            [
                'titre' => 'Conseil IT & audit numérique',
                'description_courte' => 'Un audit et une feuille de route sur-mesure pour votre transformation.',
                'description_longue' => 'Diagnostic complet de votre système d’information, choix des solutions adaptées à votre taille et votre budget, accompagnement au changement et formation de vos équipes. Nous construisons une feuille de route réaliste, sans surdimensionnement.',
                'icone' => 'chart-bar',
            ],
            [
                'titre' => 'Support et maintenance',
                'description_courte' => 'Un interlocuteur unique et des interventions rapides sur vos outils.',
                'description_longue' => 'Contrat de maintenance préventive et corrective : supervision, mises à jour, sauvegardes, assistance utilisateurs. Un ticket, une réponse rapide, une traçabilité complète de vos incidents.',
                'icone' => 'lifebuoy',
            ],
            [
                'titre' => 'Développement d’applications sur mesure',
                'description_courte' => 'Des outils web et métier conçus pour vos besoins spécifiques.',
                'description_longue' => 'Portails clients, outils de gestion interne, applications métier : nous concevons des solutions sur mesure quand les outils standards ne suffisent plus, avec une méthode itérative et un accompagnement jusqu’à la mise en production.',
                'icone' => 'rocket',
            ],
            [
                'titre' => 'Intégration ERP & CRM',
                'description_courte' => 'Centralisez votre gestion commerciale et vos données client.',
                'description_longue' => 'Nous déployons et connectons des solutions ERP et CRM à vos outils existants pour unifier le suivi commercial, la gestion des stocks et la relation client, avec une reprise de données maîtrisée et une formation des équipes.',
                'icone' => 'users',
            ],
            [
                'titre' => 'Cybersécurité & protection des données',
                'description_courte' => 'Réduisez vos risques et protégez les données de votre entreprise.',
                'description_longue' => 'Audit de sécurité, politique d’accès, chiffrement, sauvegardes et sensibilisation des équipes : nous mettons en place des mesures concrètes et proportionnées pour protéger vos données et celles de vos clients.',
                'icone' => 'shield-check',
            ],
            [
                'titre' => 'Infrastructure & cloud',
                'description_courte' => 'Une infrastructure fiable, disponible et maîtrisée en coûts.',
                'description_longue' => 'Migration progressive de vos serveurs et applications vers le cloud, dimensionnement adapté à votre activité et supervision continue pour garantir la disponibilité de vos services.',
                'icone' => 'cog',
            ],
            [
                'titre' => 'Formation & accompagnement au changement',
                'description_courte' => 'Des équipes formées et autonomes sur leurs nouveaux outils.',
                'description_longue' => 'La meilleure solution technique ne vaut rien si elle n’est pas adoptée. Nous formons vos équipes, produisons une documentation claire et accompagnons le changement sur le terrain.',
                'icone' => 'chat',
            ],
            [
                'titre' => 'Data & Business Intelligence',
                'description_courte' => 'Centralisez vos données et pilotez votre activité en temps réel.',
                'description_longue' => 'Nous centralisons vos données dispersées et construisons des tableaux de bord décisionnels lisibles, pour que vos équipes de direction prennent des décisions plus rapides et mieux informées.',
                'icone' => 'sparkles',
            ],
        ])
            ->values()
            ->map(function (array $data, int $index) {
                return Service::create([
                    ...$data,
                    'slug' => Str::slug($data['titre']),
                    'image' => '/images/placeholders/service-cover.svg',
                    'ordre_affichage' => $index + 1,
                    'actif' => true,
                ]);
            });

        $realisations = collect([
            [
                'service' => 'Digitalisation des processus métier',
                'titre' => 'Dématérialisation des dossiers patients',
                'client' => 'Clinique Sainte-Anne',
                'secteur' => 'Santé',
                'probleme' => 'La gestion papier des dossiers patients entraînait des pertes de documents récurrentes et un temps de recherche important pour le personnel soignant.',
                'solution' => 'Mise en place d’une plateforme de gestion électronique des dossiers médicaux avec un workflow de validation et des droits d’accès par profil.',
                'resultats' => 'Le temps de recherche d’un dossier est passé de plusieurs minutes à quelques secondes, et les pertes de documents ont disparu.',
                'date_realisation' => '2025-03-10',
            ],
            [
                'service' => 'Automatisation des tâches',
                'titre' => 'Automatisation de la facturation et des relances clients',
                'client' => 'Sénégal Distribution SA',
                'secteur' => 'Commerce',
                'probleme' => 'La facturation manuelle mobilisait deux personnes à temps partiel et les retards de paiement étaient mal suivis.',
                'solution' => 'Automatisation de la génération des factures et mise en place de relances automatiques par email et SMS selon l’échéance.',
                'resultats' => 'Le délai moyen de paiement a diminué et l’équipe administrative consacre désormais ce temps à d’autres tâches.',
                'date_realisation' => '2025-05-22',
            ],
            [
                'service' => 'Conseil IT & audit numérique',
                'titre' => 'Audit et feuille de route de transformation numérique',
                'client' => 'Mairie de Rufisque',
                'secteur' => 'Administration publique',
                'probleme' => 'Le système d’information de la mairie était vieillissant et aucune vision globale des priorités numériques n’existait.',
                'solution' => 'Audit complet des outils existants et élaboration d’une feuille de route priorisée sur 18 mois, adaptée au budget municipal.',
                'resultats' => 'La mairie dispose désormais d’un plan d’action clair et de solutions choisies en fonction de critères objectifs.',
                'date_realisation' => '2025-01-15',
            ],
            [
                'service' => 'Support et maintenance',
                'titre' => 'Contrat de supervision et maintenance de la flotte informatique',
                'client' => 'Groupe Teranga Transport',
                'secteur' => 'Transport',
                'probleme' => 'Les pannes informatiques n’étaient pas anticipées et l’entreprise n’avait pas d’interlocuteur unique en cas d’incident.',
                'solution' => 'Mise en place d’une supervision proactive, d’une maintenance préventive planifiée et d’une hotline dédiée.',
                'resultats' => 'Les interruptions de service ont nettement diminué et le temps de résolution des incidents a été réduit.',
                'date_realisation' => '2025-07-02',
            ],
            [
                'service' => 'Développement d’applications sur mesure',
                'titre' => 'Portail étudiant pour l’inscription et le suivi de scolarité',
                'client' => 'Institut Supérieur de Gestion Dakar',
                'secteur' => 'Éducation',
                'probleme' => 'Les inscriptions se faisaient sur papier et il n’existait aucun suivi centralisé des notes et des paiements.',
                'solution' => 'Développement d’un portail web dédié permettant aux étudiants de s’inscrire en ligne et à l’administration de suivre les dossiers.',
                'resultats' => 'Les inscriptions en ligne sont pleinement opérationnelles et la charge administrative a été réduite dès la première rentrée.',
                'date_realisation' => '2025-09-01',
            ],
            [
                'service' => 'Intégration ERP & CRM',
                'titre' => 'Déploiement d’un CRM pour le suivi commercial',
                'client' => 'Baobab Finance SARL',
                'secteur' => 'Finance',
                'probleme' => 'Le suivi des prospects était dispersé entre fichiers Excel et boîtes email, sans vue d’ensemble pour l’équipe commerciale.',
                'solution' => 'Intégration d’un CRM centralisé connecté aux outils existants, avec reprise des données historiques.',
                'resultats' => 'L’équipe commerciale dispose d’une visibilité complète sur son pipeline et suit un taux de conversion en progression.',
                'date_realisation' => '2025-04-18',
            ],
            [
                'service' => 'Cybersécurité & protection des données',
                'titre' => 'Sécurisation des données clients et mise en conformité',
                'client' => 'Cabinet Juridique Diop & Associés',
                'secteur' => 'Services juridiques',
                'probleme' => 'Le cabinet ne disposait d’aucune politique de sécurité formalisée alors qu’il traite des données clients sensibles.',
                'solution' => 'Audit de sécurité, chiffrement des données, mise en place d’une politique d’accès et de sauvegardes régulières.',
                'resultats' => 'Les risques identifiés lors de l’audit ont été traités et le cabinet peut désormais démontrer sa conformité à ses clients.',
                'date_realisation' => '2025-06-11',
            ],
            [
                'service' => 'Infrastructure & cloud',
                'titre' => 'Migration de l’infrastructure vers le cloud',
                'client' => 'Hôtel Lagon Bleu',
                'secteur' => 'Hôtellerie & Tourisme',
                'probleme' => 'Les serveurs locaux vieillissants généraient des coûts de maintenance élevés et des risques de panne.',
                'solution' => 'Migration progressive des applications et des données vers une infrastructure cloud dimensionnée à l’activité de l’hôtel.',
                'resultats' => 'La disponibilité des services s’est améliorée et les coûts d’infrastructure ont été optimisés.',
                'date_realisation' => '2025-08-20',
            ],
            [
                'service' => 'Formation & accompagnement au changement',
                'titre' => 'Formation des équipes aux nouveaux outils numériques',
                'client' => 'Coopérative Agricole de la Vallée',
                'secteur' => 'Agriculture',
                'probleme' => 'Les nouveaux outils numériques déployés étaient peu utilisés faute d’adhésion des équipes de terrain.',
                'solution' => 'Programme de formation pratique et accompagnement au changement échelonné sur plusieurs semaines.',
                'resultats' => 'Les nouveaux outils sont désormais adoptés par les équipes terrain, qui gagnent en autonomie au quotidien.',
                'date_realisation' => '2025-02-28',
            ],
            [
                'service' => 'Data & Business Intelligence',
                'titre' => 'Mise en place d’un tableau de bord décisionnel',
                'client' => 'Groupe Industriel Sahel',
                'secteur' => 'Industrie',
                'probleme' => 'Les données de production étaient dispersées entre plusieurs outils, rendant le pilotage difficile pour la direction.',
                'solution' => 'Centralisation des données de production et création de tableaux de bord de pilotage en temps réel.',
                'resultats' => 'La direction suit désormais la production en temps réel et prend ses décisions plus rapidement.',
                'date_realisation' => '2025-10-05',
            ],
        ])->map(function (array $data) use ($services) {
            $service = $services->firstWhere('titre', $data['service']);

            return Realisation::create([
                'titre' => $data['titre'],
                'slug' => Str::slug($data['titre']),
                'client' => $data['client'],
                'secteur' => $data['secteur'],
                'probleme' => $data['probleme'],
                'solution' => $data['solution'],
                'resultats' => $data['resultats'],
                'image_cover' => '/images/placeholders/realisation-cover.svg',
                'service_id' => $service->id,
                'date_realisation' => $data['date_realisation'],
                'publie' => true,
            ]);
        });

        collect([
            [
                'titre' => '5 signes qu’il est temps de digitaliser vos processus métier',
                'extrait' => 'Papiers perdus, tâches redondantes, manque de visibilité... voici les signaux qui doivent vous alerter.',
                'contenu' => "Beaucoup d’entreprises attendent qu’un incident survienne avant de digitaliser leurs processus. Pourtant, certains signaux doivent alerter bien avant : documents introuvables, ressaisie manuelle d’informations déjà disponibles ailleurs, ou encore décisions prises sans visibilité sur l’activité réelle.\n\nSi vos équipes passent plus de temps à chercher l’information qu’à l’exploiter, c’est le premier signe. Le deuxième est la dépendance à une seule personne pour retrouver un dossier ou reconstituer un historique.\n\nDigitaliser ne signifie pas tout bouleverser d’un coup. Un audit ciblé permet d’identifier les processus les plus critiques et de les traiter en priorité, avant d’étendre la démarche au reste de l’organisation.",
                'categorie' => 'Digitalisation',
            ],
            [
                'titre' => 'Automatiser sans complexifier : les bonnes pratiques',
                'extrait' => 'L’automatisation ne doit pas ajouter de la complexité. Voici comment l’aborder simplement.',
                'contenu' => "L’automatisation a mauvaise réputation quand elle est mal menée : outils empilés, processus rigides, équipes perdues. Pourtant, bien conçue, elle simplifie le quotidien plutôt qu’elle ne le complique.\n\nLa règle de base est de commencer petit : automatiser une seule tâche répétitive et bien identifiée, mesurer le gain de temps réel, puis étendre progressivement. Les relances clients, la génération de rapports périodiques ou la synchronisation entre deux outils sont souvent de bons points de départ.\n\nUne automatisation réussie reste toujours compréhensible par l’équipe qui l’utilise : si personne ne sait l’expliquer, elle deviendra une source de blocage plutôt qu’un gain de productivité.",
                'categorie' => 'Automatisation',
            ],
            [
                'titre' => 'Comment réussir l’audit de son système d’information',
                'extrait' => 'Un audit IT réussi commence par les bonnes questions. Notre méthode en quatre étapes.',
                'contenu' => "Un audit du système d’information ne se limite pas à lister les logiciels utilisés. Il doit répondre à une question simple : vos outils actuels servent-ils réellement vos objectifs métier ?\n\nNotre méthode suit quatre étapes : cartographier l’existant, identifier les points de friction remontés par les équipes, évaluer les risques (sécurité, dépendance, obsolescence), puis prioriser les actions selon leur impact et leur coût.\n\nL’objectif final n’est pas de produire un rapport qui prendra la poussière, mais une feuille de route réaliste, avec des étapes concrètes et un budget maîtrisé.",
                'categorie' => 'Conseil IT',
            ],
            [
                'titre' => 'Pourquoi les PME sénégalaises doivent investir dans le numérique',
                'extrait' => 'La transformation numérique n’est plus réservée aux grandes entreprises.',
                'contenu' => "Longtemps perçue comme un investissement réservé aux grandes structures, la transformation numérique est aujourd’hui accessible aux PME, à condition d’avancer par étapes.\n\nUne PME qui digitalise sa facturation, centralise sa relation client ou automatise ses tâches répétitives gagne un avantage concurrentiel réel : moins d’erreurs, plus de réactivité, et des équipes recentrées sur les tâches à forte valeur ajoutée.\n\nL’essentiel est de choisir des outils adaptés à la taille de l’entreprise, sans surdimensionner les investissements. Un accompagnement externe permet souvent d’éviter les faux départs.",
                'categorie' => 'PME',
            ],
            [
                'titre' => 'Cybersécurité : les réflexes essentiels pour les petites structures',
                'extrait' => 'Pas besoin d’un grand budget pour mieux protéger vos données. Voici les priorités.',
                'contenu' => "La cybersécurité est souvent vue comme un sujet réservé aux grandes entreprises disposant d’équipes IT dédiées. En réalité, les petites structures sont aussi ciblées, et souvent moins bien préparées.\n\nQuelques réflexes simples réduisent déjà une grande partie des risques : mots de passe robustes et uniques, sauvegardes régulières testées, mises à jour appliquées sans délai, et sensibilisation des équipes aux tentatives de phishing.\n\nUn audit de sécurité, même léger, permet d’identifier les priorités et d’investir intelligemment plutôt que de multiplier les outils sans cohérence d’ensemble.",
                'categorie' => 'Cybersécurité',
            ],
            [
                'titre' => 'ERP ou CRM : lequel choisir en premier ?',
                'extrait' => 'Les deux outils répondent à des besoins différents. On vous aide à y voir clair.',
                'contenu' => "ERP et CRM sont souvent confondus, alors qu’ils répondent à des besoins différents. Le CRM centralise la relation client et le suivi commercial. L’ERP, plus large, couvre la gestion globale de l’entreprise : stocks, comptabilité, ressources humaines.\n\nPour une entreprise dont la priorité est de mieux suivre ses prospects et clients, le CRM est souvent le premier pas logique. Pour une entreprise qui peine à piloter sa gestion globale, l’ERP peut être plus pertinent.\n\nDans les deux cas, la réussite du projet dépend moins de l’outil choisi que de la qualité de son intégration avec l’existant et de l’accompagnement des équipes au changement.",
                'categorie' => 'Conseil IT',
            ],
            [
                'titre' => 'Le cloud, une opportunité pour les entreprises africaines',
                'extrait' => 'Coûts maîtrisés, disponibilité renforcée : pourquoi migrer vers le cloud a du sens aujourd’hui.',
                'contenu' => "Longtemps freinée par la disponibilité et le coût de la connectivité, l’adoption du cloud progresse fortement en Afrique de l’Ouest. Pour de nombreuses entreprises, elle représente une alternative crédible aux infrastructures locales vieillissantes.\n\nLes bénéfices sont concrets : disponibilité accrue des services, sauvegardes automatisées, et une facturation qui s’ajuste à l’usage réel plutôt qu’à un investissement matériel figé.\n\nUne migration réussie se prépare : cartographie des applications concernées, choix d’un hébergeur adapté au contexte local, et plan de bascule progressif pour éviter toute interruption d’activité.",
                'categorie' => 'Digitalisation',
            ],
            [
                'titre' => 'Conduite du changement : la clé de l’adoption des outils numériques',
                'extrait' => 'La meilleure solution technique ne sert à rien si les équipes ne l’adoptent pas.',
                'contenu' => "Un projet numérique peut être techniquement parfait et échouer malgré tout, faute d’adoption par les équipes. La conduite du changement n’est pas une option secondaire : c’est une condition de réussite du projet.\n\nCela passe par une communication claire sur les raisons du changement, une formation adaptée au niveau réel des utilisateurs, et un accompagnement de proximité durant les premières semaines d’usage.\n\nImpliquer quelques utilisateurs clés dès la conception de l’outil facilite grandement son appropriation par le reste de l’équipe une fois déployé.",
                'categorie' => 'PME',
            ],
            [
                'titre' => 'Automatiser sa facturation : par où commencer ?',
                'extrait' => 'Un guide pratique pour automatiser la facturation sans bouleverser vos habitudes.',
                'contenu' => "La facturation est souvent l’un des premiers processus que les entreprises choisissent d’automatiser, car les gains sont rapides et mesurables.\n\nLa première étape consiste à standardiser vos modèles de facture et vos règles de calcul, avant même de penser à l’outil. Une fois ces règles claires, l’automatisation de la génération et de l’envoi des factures devient beaucoup plus simple à mettre en place.\n\nLes relances peuvent ensuite être automatisées selon des échéances définies, ce qui améliore généralement les délais de paiement sans alourdir la charge de travail de vos équipes.",
                'categorie' => 'Automatisation',
            ],
            [
                'titre' => 'Data & décision : comment un tableau de bord change la donne',
                'extrait' => 'Centraliser ses données de pilotage permet de prendre de meilleures décisions, plus vite.',
                'contenu' => "Beaucoup d’entreprises disposent de données précieuses, mais dispersées entre plusieurs outils et fichiers, ce qui rend leur exploitation difficile au quotidien.\n\nUn tableau de bord décisionnel centralise ces données et les présente sous une forme lisible pour les équipes de direction : indicateurs clés, tendances, alertes sur les écarts significatifs.\n\nL’enjeu n’est pas de tout mesurer, mais de choisir un nombre limité d’indicateurs réellement utiles à la prise de décision, et de les maintenir à jour de façon fiable.",
                'categorie' => 'Conseil IT',
            ],
        ])->each(function (array $data, int $index) {
            Article::create([
                ...$data,
                'slug' => Str::slug($data['titre']),
                'statut' => true,
                'publie_le' => now()->subDays(90 - $index * 7),
                'meta_title' => $data['titre'],
                'meta_description' => Str::limit($data['extrait'], 160),
            ]);
        });

        collect([
            [
                'nom_client' => 'Aïssatou Ndiaye',
                'entreprise' => 'Clinique Sainte-Anne',
                'poste' => 'Directrice administrative',
                'contenu' => 'Grâce à Xidma Software, nos dossiers patients sont enfin centralisés et accessibles en quelques secondes. Un vrai gain de sérénité pour nos équipes.',
                'note' => 5,
            ],
            [
                'nom_client' => 'Moussa Fall',
                'entreprise' => 'Sénégal Distribution SA',
                'poste' => 'Directeur financier',
                'contenu' => 'L’automatisation de notre facturation nous a fait gagner un temps précieux et nos relances clients sont désormais systématiques.',
                'note' => 5,
            ],
            [
                'nom_client' => 'Fatou Diagne',
                'entreprise' => 'Mairie de Rufisque',
                'poste' => 'Secrétaire générale',
                'contenu' => 'L’audit réalisé par Xidma nous a donné une vision claire de nos priorités numériques pour les prochaines années.',
                'note' => 4,
            ],
            [
                'nom_client' => 'Ibrahima Sarr',
                'entreprise' => 'Groupe Teranga Transport',
                'poste' => 'Responsable IT',
                'contenu' => 'Depuis notre contrat de maintenance, nous n’avons plus de mauvaise surprise. L’équipe est réactive et toujours disponible.',
                'note' => 5,
            ],
            [
                'nom_client' => 'Mariama Ba',
                'entreprise' => 'Institut Supérieur de Gestion Dakar',
                'poste' => 'Directrice des études',
                'contenu' => 'Notre portail étudiant a transformé la gestion des inscriptions. Les étudiants et l’administration y trouvent leur compte.',
                'note' => 5,
            ],
            [
                'nom_client' => 'Cheikh Diouf',
                'entreprise' => 'Baobab Finance SARL',
                'poste' => 'Directeur commercial',
                'contenu' => 'Le CRM mis en place par Xidma nous permet enfin de suivre nos prospects du premier contact jusqu’à la signature.',
                'note' => 4,
            ],
            [
                'nom_client' => 'Ndèye Coumba Sy',
                'entreprise' => 'Cabinet Juridique Diop & Associés',
                'poste' => 'Associée',
                'contenu' => 'Xidma nous a aidés à sécuriser les données de nos clients avec un vrai souci de conformité. Un partenaire de confiance.',
                'note' => 5,
            ],
            [
                'nom_client' => 'Abdoulaye Kane',
                'entreprise' => 'Hôtel Lagon Bleu',
                'poste' => 'Directeur général',
                'contenu' => 'La migration vers le cloud s’est faite sans interruption de service. Nos coûts d’infrastructure ont nettement baissé.',
                'note' => 4,
            ],
            [
                'nom_client' => 'Awa Ndiaye',
                'entreprise' => 'Coopérative Agricole de la Vallée',
                'poste' => 'Présidente',
                'contenu' => 'La formation dispensée par l’équipe de Xidma a permis à nos équipes de terrain d’adopter les nouveaux outils avec confiance.',
                'note' => 5,
            ],
            [
                'nom_client' => 'Oumar Thiam',
                'entreprise' => 'Groupe Industriel Sahel',
                'poste' => 'Directeur de production',
                'contenu' => 'Notre tableau de bord de pilotage nous donne enfin une vision en temps réel de notre production. Décisions plus rapides, plus sûres.',
                'note' => 5,
            ],
        ])->each(function (array $data) {
            Temoignage::create([
                ...$data,
                'actif' => true,
            ]);
        });

        Lead::factory()->recycle($services)->count(10)->create();
    }

    private function resetTestData(): void
    {
        Lead::query()->delete();
        Realisation::query()->delete();
        Article::query()->delete();
        Temoignage::query()->delete();
        Service::query()->delete();
        User::query()->delete();
    }
}
