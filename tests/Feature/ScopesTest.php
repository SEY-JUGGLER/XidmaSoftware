<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Realisation;
use App\Models\Service;
use App\Models\Temoignage;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ScopesTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_service_actif_scope_filters_inactif_services(): void
    {
        $actif = Service::factory()->create(['actif' => true]);
        Service::factory()->inactif()->create();

        $resultats = Service::actif()->get();

        $this->assertCount(1, $resultats);
        $this->assertTrue($resultats->contains('id', $actif->id));
        $this->assertModelExists($actif);
    }

    public function test_realisation_publie_scope_filters_non_publiee(): void
    {
        $publiee = Realisation::factory()->create(['publie' => true]);
        Realisation::factory()->nonPubliee()->create();

        $resultats = Realisation::publie()->get();

        $this->assertCount(1, $resultats);
        $this->assertTrue($resultats->contains('id', $publiee->id));
    }

    public function test_article_publie_scope_filters_brouillons(): void
    {
        $publie = Article::factory()->create(['statut' => true, 'publie_le' => now()]);
        Article::factory()->brouillon()->create();

        $resultats = Article::publie()->get();

        $this->assertCount(1, $resultats);
        $this->assertTrue($resultats->contains('id', $publie->id));
    }

    public function test_temoignage_actif_scope_filters_inactifs(): void
    {
        $actif = Temoignage::factory()->create(['actif' => true]);
        Temoignage::factory()->inactif()->create();

        $resultats = Temoignage::actif()->get();

        $this->assertCount(1, $resultats);
        $this->assertTrue($resultats->contains('id', $actif->id));
    }
}
