<?php

namespace App\Filament\Resources\Services\Tables;

use App\Models\Service;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('')
                    ->circular()
                    ->defaultImageUrl(url('/favicon.ico')),
                TextColumn::make('titre')
                    ->label('Titre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('icone')
                    ->label('Icône')
                    ->badge(),
                TextColumn::make('description_courte')
                    ->label('Description courte')
                    ->limit(60)
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('ordre_affichage')
                    ->label('Ordre')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('actif')
                    ->label('Actif')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Modifié le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('ordre_affichage')
            ->filters([
                TernaryFilter::make('actif')
                    ->label('Actif'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->before(function (DeleteBulkAction $action): void {
                            $blocked = $action->getSelectedRecords()
                                ->filter(fn (Service $service): bool => $service->realisations()->exists());

                            if ($blocked->isEmpty()) {
                                return;
                            }

                            Notification::make()
                                ->title('Suppression impossible')
                                ->body('Ces services sont liés à des réalisations et ne peuvent pas être supprimés : '.$blocked->pluck('titre')->join(', ').'.')
                                ->danger()
                                ->send();

                            $action->halt();
                        }),
                ]),
            ]);
    }
}
