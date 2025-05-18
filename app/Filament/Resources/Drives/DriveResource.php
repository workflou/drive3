<?php

namespace App\Filament\Resources\Drives;

use App\Filament\Resources\Drives\Pages\CreateDrive;
use App\Filament\Resources\Drives\Pages\EditDrive;
use App\Filament\Resources\Drives\Pages\ListDrives;
use App\Filament\Resources\Drives\Schemas\DriveForm;
use App\Filament\Resources\Drives\Tables\DrivesTable;
use App\Models\Drive;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DriveResource extends Resource
{
    protected static ?string $model = Drive::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedServerStack;

    public static function form(Schema $schema): Schema
    {
        return DriveForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DrivesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDrives::route('/'),
            'create' => CreateDrive::route('/create'),
            'edit' => EditDrive::route('/{record}/edit'),
        ];
    }
}
