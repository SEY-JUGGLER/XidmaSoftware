<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ServiceForm
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
                            ->unique(ignoreRecord: true)
                            ->helperText('Utilisé dans l’URL publique du service.'),
                        TextInput::make('description_courte')
                            ->label('Description courte')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Affichée dans les listes et les cartes de service.'),
                        Textarea::make('description_longue')
                            ->label('Description longue')
                            ->required()
                            ->rows(6)
                            ->columnSpanFull()
                            ->helperText('Affichée sur la page détaillée du service.'),
                    ]),

                Section::make('Apparence')
                    ->columns(2)
                    ->schema([
                        Select::make('icone')
                            ->label('Icône')
                            ->required()
                            ->native(false)
                            ->options([
                                'computer-desktop' => 'Ordinateur',
                                'bolt' => 'Éclair',
                                'chart-bar' => 'Graphique',
                                'lifebuoy' => 'Bouée (support)',
                                'cog' => 'Engrenage',
                                'users' => 'Utilisateurs',
                                'sparkles' => 'Étincelles',
                                'rocket' => 'Fusée',
                                'shield-check' => 'Bouclier',
                                'chat' => 'Discussion',
                                'target' => 'Cible',
                            ])
                            ->helperText('Correspond à une icône du site public.'),
                        FileUpload::make('image')
                            ->label('Image')
                            ->image()
                            ->disk('public')
                            ->directory('services')
                            ->visibility('public'),
                    ]),

                Section::make('Affichage')
                    ->columns(2)
                    ->schema([
                        TextInput::make('ordre_affichage')
                            ->label('Ordre d’affichage')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Toggle::make('actif')
                            ->label('Actif')
                            ->helperText('Un service inactif n’est plus visible sur le site.')
                            ->default(true),
                    ]),
            ]);
    }
}
