<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $titre = fake()->sentence(5);

        return [
            'titre' => $titre,
            'slug' => Str::slug($titre),
            'extrait' => fake()->sentence(15),
            'contenu' => fake()->paragraphs(4, true),
            'image_cover' => null,
            'categorie' => fake()->randomElement(['Digitalisation', 'Automatisation', 'Conseil IT', 'PME', 'Cybersécurité']),
            'statut' => true,
            'publie_le' => now(),
            'meta_title' => $titre,
            'meta_description' => Str::limit(fake()->paragraph(), 160),
        ];
    }

    /**
     * Indicate that the article is a draft (not published).
     */
    public function brouillon(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut' => false,
            'publie_le' => null,
        ]);
    }
}
