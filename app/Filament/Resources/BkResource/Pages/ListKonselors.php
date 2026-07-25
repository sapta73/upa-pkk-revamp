<?php
namespace App\Filament\Resources\BkResource\Pages;
use App\Filament\Resources\BkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKonselors extends ListRecords
{
    protected static string $resource = BkResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
