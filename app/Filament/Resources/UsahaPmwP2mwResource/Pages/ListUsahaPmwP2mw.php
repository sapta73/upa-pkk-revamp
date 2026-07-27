<?php

namespace App\Filament\Resources\UsahaPmwP2mwResource\Pages;

use App\Filament\Resources\UsahaPmwP2mwResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsahaPmwP2mw extends ListRecords
{
    protected static string $resource = UsahaPmwP2mwResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Usaha Baru'),
        ];
    }
}
