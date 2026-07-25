<?php
namespace App\Filament\Resources\BkResource\Pages;
use App\Filament\Resources\BkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKonselor extends EditRecord
{
    protected static string $resource = BkResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
