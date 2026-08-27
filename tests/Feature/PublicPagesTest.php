<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Realisation;
use App\Models\Service;
use App\Models\Temoignage;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_accueil_rend_le_composant_home(): void
    {
        $services = Service::factory()->count(3)->create();
        Realisation::factory()->count(3)->create(['service_id' => $services->random()->id]);
        Temoignage::factory()->count(3)->create();
        Article::factory()->count(3)->create();

        $this->get('/')->assertInertia(
            fn ($page) => $page->component('Home')
                ->has('services', 3)
                ->has('realisations', 3)
                ->has('temoignages', 3)
                ->has('articles', 3)
        );
    }

    public function test_services_index_ne_liste_que_les_services_actifs(): void
    {
        Service::factory()->count(2)->create();
        Service::factory()->inactif()->count(1)->create();

        $this->get('/services')->assertInertia(
            fn ($page) => $page->component('Services/Index')->has('services', 2)
        );
    }

    public function test_service_show_resout_par_slug(): void
    {
        $service = Service::factory()->create(['slug' => 'digitalisation']);
        Realisation::factory()->count(2)->create(['service_id' => $service->id]);

        $this->get("/services/{$service->slug}")->assertInertia(
            fn ($page) => $page->component('Services/Show')
                ->where('service.slug', 'digitalisation')
                ->has('realisations', 2)
        );
    }

    public function test_service_inactif_renvoie_404(): void
    {
        $service = Service::factory()->inactif()->create();

        $this->get("/services/{$service->slug}")->assertNotFound();
    }

    public function test_realisations_index_ne_liste_que_les_publiees(): void
    {
        Realisation::factory()->count(2)->create();
        Realisation::factory()->nonPubliee()->count(1)->create();

        $this->get('/realisations')->assertInertia(
            fn ($page) => $page->component('Realisations/Index')->has('realisations', 2)
        );
    }

    public function test_realisation_show_resout_par_slug(): void
    {
        $realisation = Realisation::factory()->create(['slug' => 'refonte-plateforme']);

        $this->get("/realisations/{$realisation->slug}")->assertInertia(
            fn ($page) => $page->component('Realisations/Show')
                ->where('realisation.slug', 'refonte-plateforme')
        );
    }

    public function test_realisation_non_publiee_renvoie_404(): void
    {
        $realisation = Realisation::factory()->nonPubliee()->create();

        $this->get("/realisations/{$realisation->slug}")->assertNotFound();
    }

    public function test_blog_index_page_les_articles_publies(): void
    {
        Article::factory()->count(10)->create();
        Article::factory()->brouillon()->count(1)->create();

        $this->get('/blog')->assertInertia(
            fn ($page) => $page->component('Blog/Index')->where('articles.total', 10)
        );
    }

    public function test_article_show_resout_par_slug(): void
    {
        $article = Article::factory()->create(['slug' => 'digitaliser-sa-pme']);

        $this->get("/blog/{$article->slug}")->assertInertia(
            fn ($page) => $page->component('Blog/Show')
                ->where('article.slug', 'digitaliser-sa-pme')
        );
    }

    public function test_article_brouillon_renvoie_404(): void
    {
        $article = Article::factory()->brouillon()->create();

        $this->get("/blog/{$article->slug}")->assertNotFound();
    }

    public function test_contact_get_liste_les_services_actifs(): void
    {
        Service::factory()->count(3)->create();

        $this->get('/contact')->assertInertia(
            fn ($page) => $page->component('Contact')->has('services', 3)
        );
    }
}
