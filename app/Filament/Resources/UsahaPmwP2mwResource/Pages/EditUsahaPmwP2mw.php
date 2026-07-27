<?php

namespace App\Filament\Resources\UsahaPmwP2mwResource\Pages;

use App\Filament\Resources\UsahaPmwP2mwResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUsahaPmwP2mw extends EditRecord
{
    protected static string $resource = UsahaPmwP2mwResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Data usaha berhasil diperbarui!';
    }
}
