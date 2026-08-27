<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\Realisation;
use App\Models\Service;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ModelGuardingTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_service_rejette_les_champs_non_fillables(): void
    {
        $service = new Service([
            'slug' => 'service-guard-test',
            'attribut_pirate' => 'valeur',
        ]);

        $this->assertEquals('service-guard-test', $service->slug);
        $this->assertFalse($service->hasAttribute('attribut_pirate'));
    }

    public function test_realisation_rejette_les_champs_non_fillables(): void
    {
        $realisation = new Realisation([
            'titre' => 'Refonte SI',
            'facture_id' => 123456,
        ]);

        $this->assertEquals('Refonte SI', $realisation->titre);
        $this->assertFalse($realisation->hasAttribute('facture_id'));
    }

    public function test_lead_rejette_les_champs_non_fillables(): void
    {
        $lead = new Lead([
            'email' => 'lead@example.com',
            'is_admin' => true,
        ]);

        $this->assertEquals('lead@example.com', $lead->email);
        $this->assertFalse($lead->hasAttribute('is_admin'));
    }
}
