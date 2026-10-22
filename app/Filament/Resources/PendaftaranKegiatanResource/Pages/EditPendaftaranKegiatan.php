<?php

namespace App\Filament\Resources\PendaftaranKegiatanResource\Pages;

use App\Filament\Resources\PendaftaranKegiatanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendaftaranKegiatan extends EditRecord
{
    protected static string $resource = PendaftaranKegiatanResource::class;

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
        return 'Pendaftaran kegiatan berhasil diperbarui.';
    }
}
