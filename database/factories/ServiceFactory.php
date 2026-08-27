<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titre = 'Prestation '.fake()->unique()->words(mt_rand(2, 4), true);

        return [
            'titre' => $titre,
            'slug' => Str::slug($titre),
            'description_courte' => fake()->sentence(10),
            'description_longue' => fake()->paragraphs(3, true),
            'icone' => fake()->randomElement(['computer-desktop', 'bolt', 'chart-bar', 'cog', 'users', 'lifebuoy']),
            'image' => null,
            'ordre_affichage' => fake()->numberBetween(1, 10),
            'actif' => true,
        ];
    }

    /**
     * Indicate that the service is inactive.
     */
    public function inactif(): static
    {
        return $this->state(fn (array $attributes) => [
            'actif' => false,
        ]);
    }
}
