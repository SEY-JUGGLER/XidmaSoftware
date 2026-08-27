<?php

namespace Tests\Feature;

use App\Mail\ConfirmationContact;
use App\Mail\NouveauContact;
use App\Models\Lead;
use App\Models\Service;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFlowTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_soumission_valide_cree_un_lead_et_queues_les_emails(): void
    {
        Mail::fake();

        $service = Service::factory()->create();

        $this->post('/contact', [
            'nom' => 'Awa Ndiaye',
            'email' => 'awa.ndiaye@example.com',
            'telephone' => '+221 77 123 45 67',
            'entreprise' => 'Clinique Premium Dakar',
            'service_interesse_id' => $service->id,
            'message' => 'Bonjour, je souhaite digitaliser ma gestion de rendez-vous.',
        ])->assertRedirect()->assertSessionHas('success');

        $this->assertDatabaseHas('leads', [
            'nom' => 'Awa Ndiaye',
            'email' => 'awa.ndiaye@example.com',
            'service_interesse_id' => $service->id,
        ]);

        $lead = Lead::query()->where('email', 'awa.ndiaye@example.com')->firstOrFail();

        Mail::assertQueued(NouveauContact::class, fn (NouveauContact $mail) => $mail->lead->is($lead));
        Mail::assertQueued(ConfirmationContact::class, fn (ConfirmationContact $mail) => $mail->lead->is($lead));
    }

    public function test_soumission_sans_service_interesse_cree_un_lead(): void
    {
        $this->post('/contact', [
            'nom' => 'Moussa Fall',
            'email' => 'moussa.fall@example.com',
            'message' => 'Besoin de conseil IT.',
        ])->assertRedirect()->assertSessionHas('success');

        $this->assertDatabaseHas('leads', [
            'nom' => 'Moussa Fall',
            'service_interesse_id' => null,
        ]);
    }

    public function test_soumission_invalide_renvoie_les_erreurs_de_validation(): void
    {
        $this->post('/contact', [
            'nom' => '',
            'email' => 'email-invalide',
        ])->assertSessionHasErrors(['nom', 'email']);

        $this->assertDatabaseCount('leads', 0);
    }

    public function test_email_invalide_est_rejete(): void
    {
        $this->post('/contact', [
            'nom' => 'Test',
            'email' => 'pas-un-email',
        ])->assertSessionHasErrors(['email']);

        $this->assertDatabaseCount('leads', 0);
    }

    public function test_service_interesse_invalide_est_rejete(): void
    {
        $this->post('/contact', [
            'nom' => 'Test',
            'email' => 'test@example.com',
            'service_interesse_id' => 9999,
        ])->assertSessionHasErrors(['service_interesse_id']);

        $this->assertDatabaseCount('leads', 0);
    }

    public function test_honeypot_rempli_ne_cree_pas_de_lead(): void
    {
        Mail::fake();

        $this->post('/contact', [
            'nom' => 'Robot',
            'email' => 'robot@example.com',
            'website' => 'http://spam.example.com',
        ])->assertRedirect()->assertSessionHas('success');

        $this->assertDatabaseCount('leads', 0);
        Mail::assertNothingQueued();
    }
}
