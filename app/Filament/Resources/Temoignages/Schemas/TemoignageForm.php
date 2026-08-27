<?php

namespace App\Filament\Resources\Temoignages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TemoignageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Client')
                    ->columns(3)
                    ->schema([
                        TextInput::make('nom_client')
                            ->label('Nom du client')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('entreprise')
                            ->label('Entreprise')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('poste')
                            ->label('Poste')
                            ->maxLength(255),
                    ]),

                Section::make('Témoignage')
                    ->columns(2)
                    ->schema([
                        Textarea::make('contenu')
                            ->label('Témoignage')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                        Select::make('note')
                            ->label('Note')
                            ->required()
                            ->native(false)
                            ->options([
                                5 => '★★★★★',
                                4 => '★★★★☆',
                                3 => '★★★☆☆',
                                2 => '★★☆☆☆',
                                1 => '★☆☆☆☆',
                            ])
                            ->default(5),
                        FileUpload::make('photo')
                            ->label('Photo')
                            ->image()
                            ->disk('public')
                            ->directory('temoignages')
                            ->visibility('public'),
                        Toggle::make('actif')
                            ->label('Actif')
                            ->helperText('Un témoignage inactif n’est plus visible sur le site.')
                            ->default(true)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
