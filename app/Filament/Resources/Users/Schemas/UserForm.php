<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Rules\Password;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama')
                    ->string()
                    ->minLength(3)
                    ->maxLength(20)
                    ->required()
                    ->columnSpan(fn ($livewire) => $livewire instanceof \App\Filament\Resources\Users\Pages\EditUser ? 2 : null),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->unique()
                    ->required(),
                TextInput::make('old_password')
                    ->label('Kata sandi lama')
                    ->password()
                    ->string()
                    ->visibleOn(['edit'])
                    ->dehydrated(false),
                TextInput::make('password')
                    ->label(fn ($livewire) => $livewire instanceof \App\Filament\Resources\Users\Pages\CreateUser ? 'Kata sandi' : 'Kata sandi baru')
                    ->rules([Password::default()])
                    ->password()
                    ->string()
                    ->required(fn ($livewire) => $livewire instanceof \App\Filament\Resources\Users\Pages\CreateUser)
                    ->requiredWith('old_password')
                    ->confirmed()
                    ->dehydrated(fn ($state) => filled($state)),
                TextInput::make('password_confirmation')
                    ->label('Konfirmasi kata sandi')
                    ->password()
                    ->string()
                    ->required(fn ($livewire) => $livewire instanceof \App\Filament\Resources\Users\Pages\CreateUser)
                    ->requiredWith('password')
                    ->dehydrated(fn ($state) => filled($state)),
                Select::make('status')
                    ->label('Status')
                    ->searchable()
                    ->relationship('statuses', 'name', fn ($query) => $query->where('type', 'user'))
                    ->preload()
                    ->required()
                    ->default('pending-activation'),
                Select::make('roles')
                    ->label('Peran')
                    ->placeholder('Pilih peran...')
                    ->searchable()
                    ->relationship('roles', 'name', fn ($query) => $query->where('name', '!=', 'owner'))
                    ->preload()
                    ->required()
                    ->default('student'),
            ]);
    }
}
