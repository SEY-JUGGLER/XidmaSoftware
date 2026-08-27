<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Contenu')
                    ->columns(2)
                    ->schema([
                        TextInput::make('titre')
                            ->label('Titre')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, ?string $state, Set $set) {
                                if ($operation !== 'create') {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                                $set('meta_title', $state);
                            }),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->alphaDash()
                            ->unique(ignoreRecord: true),
                        TextInput::make('categorie')
                            ->label('Catégorie')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Ex : Digitalisation, Automatisation, Conseil IT, PME, Cybersécurité…'),
                        TextInput::make('extrait')
                            ->label('Extrait')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Court résumé affiché dans les listes d’articles.'),
                        Textarea::make('contenu')
                            ->label('Contenu')
                            ->required()
                            ->rows(12)
                            ->columnSpanFull(),
                        FileUpload::make('image_cover')
                            ->label('Image de couverture')
                            ->image()
                            ->disk('public')
                            ->directory('articles')
                            ->visibility('public'),
                    ]),

                Section::make('Publication')
                    ->columns(2)
                    ->schema([
                        Toggle::make('statut')
                            ->label('Publié')
                            ->live()
                            ->default(false)
                            ->afterStateUpdated(function (bool $state, Set $set, Get $get) {
                                if ($state && blank($get('publie_le'))) {
                                    $set('publie_le', now());
                                }
                            }),
                        DateTimePicker::make('publie_le')
                            ->label('Publié le'),
                    ]),

                Section::make('SEO')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta titre')
                            ->maxLength(255),
                        TextInput::make('meta_description')
                            ->label('Meta description')
                            ->maxLength(255),
                    ]),
            ]);
    }
}
