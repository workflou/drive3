<?php

namespace App\Filament\Resources\Drives\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DrivesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->emptyStateDescription('You don\'t have any drives yet.')
            ->emptyStateHeading('No Drives')
            ->emptyStateIcon(Heroicon::OutlinedServer)
            ->emptyStateActions([
                Action::make('create')
                    ->label('Connect a Google Drive')
                    ->url('/todo')
                    ->icon('heroicon-o-plus')
                    ->color('primary'),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->columns([
                TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
