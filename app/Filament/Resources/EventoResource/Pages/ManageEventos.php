<?php

namespace App\Filament\Resources\EventoResource\Pages;

use App\Filament\Resources\EventoResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEventos extends ManageRecords
{
    protected static string $resource = EventoResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
