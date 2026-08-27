<?php

namespace Tests\Feature;

use App\Filament\Resources\Services\Pages\EditService;
use App\Models\Realisation;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class FilamentAdminTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_invite_est_redirige_vers_la_connexion(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    /**
     * @return array<string, array{0: string}>
     */
    public static function resource_slugs(): array
    {
        return [
            'services' => ['services'],
            'realisations' => ['realisations'],
            'articles' => ['articles'],
            'temoignages' => ['temoignages'],
            'leads' => ['leads'],
        ];
    }

    #[DataProvider('resource_slugs')]
    public function test_admin_peut_voir_la_liste_de_la_ressource(string $slug): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->get("/admin/{$slug}")->assertOk();
    }

    #[DataProvider('resource_slugs')]
    public function test_admin_peut_voir_le_formulaire_de_creation(string $slug): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->get("/admin/{$slug}/create")->assertOk();
    }

    public function test_admin_peut_voir_le_formulaire_edition_dune_realisation(): void
    {
        $admin = User::factory()->create();
        $service = Service::factory()->create();
        $realisation = Realisation::factory()->create(['service_id' => $service->id]);

        $this->actingAs($admin)
            ->get("/admin/realisations/{$realisation->id}/edit")
            ->assertOk();
    }

    public function test_admin_ne_peut_pas_supprimer_un_service_lie_a_des_realisations(): void
    {
        $admin = User::factory()->create();
        $service = Service::factory()->create();
        Realisation::factory()->create(['service_id' => $service->id]);

        Livewire::actingAs($admin)
            ->test(EditService::class, ['record' => $service->getRouteKey()])
            ->callAction('delete');

        $this->assertDatabaseHas('services', ['id' => $service->id]);
    }

    public function test_admin_peut_supprimer_un_service_sans_realisations(): void
    {
        $admin = User::factory()->create();
        $service = Service::factory()->create();

        Livewire::actingAs($admin)
            ->test(EditService::class, ['record' => $service->getRouteKey()])
            ->callAction('delete');

        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }
}
