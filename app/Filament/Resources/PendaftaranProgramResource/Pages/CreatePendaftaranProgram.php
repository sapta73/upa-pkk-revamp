<?php

namespace App\Filament\Resources\PendaftaranProgramResource\Pages;

use App\Filament\Resources\PendaftaranProgramResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePendaftaranProgram extends CreateRecord
{
    protected static string $resource = PendaftaranProgramResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Pendaftaran program berhasil ditambahkan.';
    }
}
