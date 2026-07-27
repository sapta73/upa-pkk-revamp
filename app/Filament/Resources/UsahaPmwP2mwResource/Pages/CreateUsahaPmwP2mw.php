<?php

namespace App\Filament\Resources\UsahaPmwP2mwResource\Pages;

use App\Filament\Resources\UsahaPmwP2mwResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUsahaPmwP2mw extends CreateRecord
{
    protected static string $resource = UsahaPmwP2mwResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data usaha berhasil ditambahkan!';
    }
}
