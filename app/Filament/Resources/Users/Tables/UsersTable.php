<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('username')
                    ->searchable(),
                BadgeColumn::make('roles.name')
                    ->label('Peran')
                    ->searchable()
                    ->sortable()
                    ->colors([
                        'primary' => 'owner',
                        'secondary' => 'admin',
                        'warning' => 'teacher',
                        'success' => 'student',
                        'info' => 'supervisor',
                    ]),
                BadgeColumn::make('status')
                    ->getStateUsing(fn (User $record)
                        => $record->statuses()->latest()->first()?->name)
                    ->color(fn (string $state, User $record)
                        => $record->statuses()->firstWhere('name', $state)?->color)
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordUrl(
                fn (User $record) => $record->id !== auth()->id() || !User::isOwner($record->id)
                    ? route('filament.admin.resources.users.edit', ['record' => $record])
                    : null,
            )
            ->recordActions([
                EditAction::make()
                    ->disabled(
                        fn (User $record) => $record->id === auth()->id() || User::isOwner($record->id)
                    )
                    ->visible(
                        fn (User $record) => !User::isOwner($record->id)
                    )
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->requiresConfirmation(),
                ]),
            ])
            ->checkIfRecordIsSelectableUsing(
                fn (User $record): bool => $record->id !== auth()->id(),
            );
    }
}
