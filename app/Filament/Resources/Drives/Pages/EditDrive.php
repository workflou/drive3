<?php

namespace App\Filament\Resources\Drives\Pages;

use App\Filament\Resources\Drives\DriveResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDrive extends EditRecord
{
    protected static string $resource = DriveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
