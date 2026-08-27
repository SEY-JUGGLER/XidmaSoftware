<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\Realisation;
use App\Models\Service;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class RelationsTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_service_has_many_realisations(): void
    {
        $service = Service::factory()->create();

        Realisation::factory()->count(3)->create(['service_id' => $service->id]);

        $this->assertCount(3, $service->realisations);
    }

    public function test_realisation_belongs_to_service(): void
    {
        $service = Service::factory()->create();
        $realisation = Realisation::factory()->create(['service_id' => $service->id]);

        $this->assertTrue($realisation->service->is($service));
    }

    public function test_lead_belongs_to_service_interesse(): void
    {
        $service = Service::factory()->create();
        $lead = Lead::factory()->create(['service_interesse_id' => $service->id]);

        $this->assertTrue($lead->serviceInteresse->is($service));
    }

    public function test_lead_can_be_created_without_service(): void
    {
        $lead = Lead::factory()->sansService()->create();

        $this->assertNull($lead->service_interesse_id);
        $this->assertNull($lead->serviceInteresse);
    }
}
