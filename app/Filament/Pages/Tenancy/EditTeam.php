<?php

namespace App\Filament\Pages\Tenancy;

use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;

class EditTeam extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return __('Team settings');
    }

    public function getFormContentComponent(): Component
    {
        return Section::make([
            Form::make([EmbeddedSchema::make('form')])
                ->id('form')
                ->livewireSubmitHandler('save')
                ->footer([
                    Actions::make($this->getFormActions())
                        ->alignment($this->getFormActionsAlignment())
                        ->fullWidth($this->hasFullWidthFormActions())
                        ->sticky($this->areFormActionsSticky()),
                ])
        ])
            ->heading(Filament::getTenant()->name)
            ->description(__('Change team\'s name'))
            ->aside();
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

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getFormContentComponent(),
            ]);
    }
}
