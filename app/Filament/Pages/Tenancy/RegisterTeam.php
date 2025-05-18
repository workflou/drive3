<?php

namespace App\Filament\Pages\Tenancy;

use App\Enums\TeamRole;
use App\Enums\TeamType;
use App\Models\TeamUser;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RegisterTeam extends RegisterTenant
{
    public static function getLabel(): string
    {
        return __('Create a new team');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->autofocus()
                    ->label(__('Team Name'))
                    ->maxLength(255)
            ]);
    }

    protected function handleRegistration(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $team = auth()->user()->teams()->create([
                'name' => $data['name'],
                'type' => TeamType::Business,
            ], [
                'role' => TeamRole::Owner,
            ]);

            auth()->user()->update([
                'team_id' => $team->id,
            ]);


            return $team;
        });
    }
}
