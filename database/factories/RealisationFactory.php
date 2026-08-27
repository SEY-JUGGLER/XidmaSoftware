<?php

namespace Database\Factories;

use App\Models\Realisation;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Realisation>
 */
class RealisationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titre' => fake()->sentence(4),
            'slug' => Str::slug(fake()->unique()->words(4, true)),
            'client' => fake()->company(),
            'secteur' => fake()->randomElement(['Santé', 'Commerce', 'Administration publique', 'Transport', 'Éducation', 'Finance']),
            'probleme' => fake()->paragraph(3),
            'solution' => fake()->paragraph(3),
            'resultats' => fake()->paragraph(2),
            'image_cover' => null,
            'service_id' => Service::factory(),
            'date_realisation' => fake()->date('Y-m-d'),
            'publie' => true,
        ];
    }

    /**
     * Indicate that the realisation is not published.
     */
    public function nonPubliee(): static
    {
        return $this->state(fn (array $attributes) => [
            'publie' => false,
        ]);
    }
}
