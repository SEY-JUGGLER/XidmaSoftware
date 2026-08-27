<?php

namespace App\Filament\Resources\Realisations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class RealisationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informations générales')
                    ->columns(2)
                    ->schema([
                        TextInput::make('titre')
                            ->label('Titre')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, ?string $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->alphaDash()
                            ->unique(ignoreRecord: true),
                        TextInput::make('client')
                            ->label('Client')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('secteur')
                            ->label('Secteur')
                            ->required()
                            ->maxLength(255),
                        Select::make('service_id')
                            ->label('Service concerné')
                            ->relationship('service', 'titre')
                            ->searchable()
                            ->preload()
                            ->required(),
                        DatePicker::make('date_realisation')
                            ->label('Date de réalisation')
                            ->required()
                            ->default(now()),
                    ]),

                Section::make('Le projet')
                    ->columns(1)
                    ->schema([
                        Textarea::make('probleme')
                            ->label('Problème')
                            ->required()
                            ->rows(4),
                        Textarea::make('solution')
                            ->label('Solution')
                            ->required()
                            ->rows(4),
                        Textarea::make('resultats')
                            ->label('Résultats')
                            ->required()
                            ->rows(3),
                    ]),

                Section::make('Apparence & publication')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('image_cover')
                            ->label('Image de couverture')
                            ->image()
                            ->disk('public')
                            ->directory('realisations')
                            ->visibility('public'),
                        Toggle::make('publie')
                            ->label('Publiée')
                            ->helperText('Une réalisation non publiée n’apparaît pas sur le site.')
                            ->default(false),
                    ]),
            ]);
    }
}
