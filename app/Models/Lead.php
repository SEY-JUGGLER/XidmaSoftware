<?php

namespace App\Models;

use Database\Factories\LeadFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['nom', 'email', 'telephone', 'entreprise', 'service_interesse_id', 'message', 'source', 'statut'])]
class Lead extends Model
{
    /** @use HasFactory<LeadFactory> */
    use HasFactory;

    public function serviceInteresse(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_interesse_id');
    }
}
