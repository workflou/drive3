<?php

namespace App\Filament\Resources\Drives\Pages;

use App\Filament\Resources\Drives\DriveResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDrives extends ListRecords
{
    protected static string $resource = DriveResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getBreadcrumb(): ?string
    {
        return null;
    }
}
