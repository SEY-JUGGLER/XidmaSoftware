<?php

namespace App\Models;

use Database\Factories\RealisationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['titre', 'slug', 'client', 'secteur', 'probleme', 'solution', 'resultats', 'image_cover', 'service_id', 'date_realisation', 'publie'])]
class Realisation extends Model
{
    /** @use HasFactory<RealisationFactory> */
    use HasFactory;

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    #[Scope]
    protected function publie(Builder $query): Builder
    {
        return $query->where('publie', true);
    }

    protected function casts(): array
    {
        return [
            'date_realisation' => 'date',
            'publie' => 'boolean',
        ];
    }
}
