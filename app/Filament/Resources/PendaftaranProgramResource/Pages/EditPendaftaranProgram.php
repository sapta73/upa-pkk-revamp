<?php

namespace App\Filament\Resources\PendaftaranProgramResource\Pages;

use App\Filament\Resources\PendaftaranProgramResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendaftaranProgram extends EditRecord
{
    protected static string $resource = PendaftaranProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Pendaftaran program berhasil diperbarui.';
    }
}
