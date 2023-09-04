<?php

namespace App\Filament\Resources\TeamResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Laravel\Jetstream\Jetstream;

class UsersRelationManager extends RelationManager
{
protected static string $relationship = 'users';

public function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Select::make('role')
                ->options(collect(Jetstream::$roles)->pluck('key', 'key'))
                ->required()
                ->native(false),
        ]);
}

public function table(Table $table): Table
{
    return $table
        ->recordTitleAttribute('name')
        ->columns([
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('role'),
        ])
        ->filters([
            //
        ])
        ->headerActions([
            Tables\Actions\AttachAction::make(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DetachAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DetachBulkAction::make(),
            ]),
        ])
        ->emptyStateActions([
            Tables\Actions\AttachAction::make(),
        ]);
}
}
