<?php

namespace Database\Factories;

use App\Models\Lead;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lead>
 */
class LeadFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'telephone' => fake()->phoneNumber(),
            'entreprise' => fake()->company(),
            'service_interesse_id' => Service::factory(),
            'message' => fake()->paragraph(2),
            'source' => 'web',
            'statut' => 'nouveau',
        ];
    }

    /**
     * Indicate that the lead has no linked service.
     */
    public function sansService(): static
    {
        return $this->state(fn (array $attributes) => [
            'service_interesse_id' => null,
        ]);
    }
}
