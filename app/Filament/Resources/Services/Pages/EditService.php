<?php

namespace App\Filament\Resources\Services\Pages;

use App\Filament\Resources\Services\ServiceResource;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->before(function (DeleteAction $action): void {
                    if (! $this->record->realisations()->exists()) {
                        return;
                    }

                    Notification::make()
                        ->title('Suppression impossible')
                        ->body('Ce service est lié à des réalisations. Supprimez-les ou réaffectez-les à un autre service avant de continuer.')
                        ->danger()
                        ->send();

                    $action->halt();
                }),
        ];
    }
}
