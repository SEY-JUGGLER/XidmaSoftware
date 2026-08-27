<?php

namespace Database\Factories;

use App\Models\Temoignage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Temoignage>
 */
class TemoignageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom_client' => fake()->name(),
            'entreprise' => fake()->company(),
            'poste' => fake()->jobTitle(),
            'contenu' => fake()->paragraph(2),
            'note' => fake()->numberBetween(4, 5),
            'photo' => null,
            'actif' => true,
        ];
    }

    /**
     * Indicate that the testimonial is inactive.
     */
    public function inactif(): static
    {
        return $this->state(fn (array $attributes) => [
            'actif' => false,
        ]);
    }
}
