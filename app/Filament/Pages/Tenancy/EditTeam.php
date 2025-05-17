<?php

namespace App\Filament\Pages\Tenancy;

use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Schemas\Schema;

class EditTeam extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return __('Team settings');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label(__('Team name'))
                    ->required()
                    ->maxLength(255)
            ]);
    }
}
