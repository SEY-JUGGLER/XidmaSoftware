<?php

namespace App\Models;

use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['titre', 'slug', 'description_courte', 'description_longue', 'icone', 'image', 'ordre_affichage', 'actif'])]
class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory;

    public function realisations(): HasMany
    {
        return $this->hasMany(Realisation::class);
    }

    #[Scope]
    protected function actif(Builder $query): Builder
    {
        return $query->where('actif', true);
    }

    protected function casts(): array
    {
        return [
            'ordre_affichage' => 'integer',
            'actif' => 'boolean',
        ];
    }
}
