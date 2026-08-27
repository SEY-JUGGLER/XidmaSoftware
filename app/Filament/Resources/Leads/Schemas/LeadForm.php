<?php

namespace App\Filament\Resources\Leads\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Contact')
                    ->columns(2)
                    ->schema([
                        TextInput::make('nom')
                            ->label('Nom')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Adresse email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('telephone')
                            ->label('Téléphone')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('entreprise')
                            ->label('Entreprise')
                            ->maxLength(255),
                    ]),

                Section::make('Demande')
                    ->columns(2)
                    ->schema([
                        Select::make('service_interesse_id')
                            ->label('Service concerné')
                            ->relationship('serviceInteresse', 'titre')
                            ->searchable()
                            ->preload(),
                        Select::make('source')
                            ->label('Source')
                            ->required()
                            ->native(false)
                            ->options([
                                'web' => 'Site web',
                                'telephone' => 'Téléphone',
                                'email' => 'Email',
                                'autre' => 'Autre',
                            ])
                            ->default('web'),
                        Select::make('statut')
                            ->label('Statut')
                            ->required()
                            ->native(false)
                            ->options([
                                'nouveau' => 'Nouveau',
                                'contacte' => 'Contacté',
                                'qualifie' => 'Qualifié',
                                'converti' => 'Converti',
                                'perdu' => 'Perdu',
                            ])
                            ->default('nouveau'),
                        Textarea::make('message')
                            ->label('Message')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
