<?php

namespace App\Filament\Resources\Leads\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LeadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nom')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('telephone')
                    ->label('Téléphone')
                    ->searchable(),
                TextColumn::make('entreprise')
                    ->label('Entreprise')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('serviceInteresse.titre')
                    ->label('Service')
                    ->badge()
                    ->color('info')
                    ->default('—'),
                TextColumn::make('source')
                    ->label('Source')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'web' => 'Site web',
                        'telephone' => 'Téléphone',
                        'email' => 'Email',
                        default => 'Autre',
                    }),
                TextColumn::make('statut')
                    ->label('Statut')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'nouveau' => 'Nouveau',
                        'contacte' => 'Contacté',
                        'qualifie' => 'Qualifié',
                        'converti' => 'Converti',
                        'perdu' => 'Perdu',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'nouveau' => 'info',
                        'contacte' => 'warning',
                        'qualifie' => 'primary',
                        'converti' => 'success',
                        'perdu' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Reçu le')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('statut')
                    ->label('Statut')
                    ->options([
                        'nouveau' => 'Nouveau',
                        'contacte' => 'Contacté',
                        'qualifie' => 'Qualifié',
                        'converti' => 'Converti',
                        'perdu' => 'Perdu',
                    ]),
                SelectFilter::make('source')
                    ->label('Source')
                    ->options([
                        'web' => 'Site web',
                        'telephone' => 'Téléphone',
                        'email' => 'Email',
                        'autre' => 'Autre',
                    ]),
                SelectFilter::make('service_interesse_id')
                    ->label('Service')
                    ->relationship('serviceInteresse', 'titre')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
