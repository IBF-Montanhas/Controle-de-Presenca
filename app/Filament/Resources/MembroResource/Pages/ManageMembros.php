<?php

namespace App\Filament\Resources\MembroResource\Pages;

use App\Filament\Resources\MembroResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMembros extends ManageRecords
{
    protected static string $resource = MembroResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
