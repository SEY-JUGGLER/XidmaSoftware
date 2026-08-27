<?php

namespace App\Models;

use Database\Factories\TemoignageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nom_client', 'entreprise', 'poste', 'contenu', 'note', 'photo', 'actif'])]
class Temoignage extends Model
{
    /** @use HasFactory<TemoignageFactory> */
    use HasFactory;

    #[Scope]
    protected function actif(Builder $query): Builder
    {
        return $query->where('actif', true);
    }

    protected function casts(): array
    {
        return [
            'note' => 'integer',
            'actif' => 'boolean',
        ];
    }
}
