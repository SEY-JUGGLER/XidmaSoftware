<?php

namespace App\Filament\Resources\Realisations\Tables;

use App\Models\Realisation;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class RealisationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_cover')
                    ->label('')
                    ->circular(),
                TextColumn::make('titre')
                    ->label('Titre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('client')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('secteur')
                    ->label('Secteur')
                    ->badge()
                    ->searchable(),
                TextColumn::make('service.titre')
                    ->label('Service')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('date_realisation')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                IconColumn::make('publie')
                    ->label('Publiée')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Créée le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Modifiée le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('date_realisation', 'desc')
            ->filters([
                SelectFilter::make('service_id')
                    ->label('Service')
                    ->relationship('service', 'titre')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('secteur')
                    ->label('Secteur')
                    ->options(fn () => Realisation::query()->distinct()->orderBy('secteur')->pluck('secteur', 'secteur')->all()),
                TernaryFilter::make('publie')
                    ->label('Publiée'),
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
