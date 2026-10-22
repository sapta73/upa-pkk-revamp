<?php

namespace App\Filament\Resources\PendaftaranKegiatanResource\Pages;

use App\Filament\Resources\PendaftaranKegiatanResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePendaftaranKegiatan extends CreateRecord
{
    protected static string $resource = PendaftaranKegiatanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Pendaftaran kegiatan berhasil ditambahkan.';
    }
}
