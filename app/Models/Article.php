<?php

namespace App\Models;

use Database\Factories\ArticleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['titre', 'slug', 'extrait', 'contenu', 'image_cover', 'categorie', 'statut', 'publie_le', 'meta_title', 'meta_description'])]
class Article extends Model
{
    /** @use HasFactory<ArticleFactory> */
    use HasFactory;

    #[Scope]
    protected function publie(Builder $query): Builder
    {
        return $query->where('statut', true);
    }

    protected function casts(): array
    {
        return [
            'statut' => 'boolean',
            'publie_le' => 'datetime',
        ];
    }
}
