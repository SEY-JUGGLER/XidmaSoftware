<?php

namespace App\Filament\Resources\Realisations\Pages;

use App\Filament\Resources\Realisations\RealisationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRealisation extends EditRecord
{
    protected static string $resource = RealisationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
