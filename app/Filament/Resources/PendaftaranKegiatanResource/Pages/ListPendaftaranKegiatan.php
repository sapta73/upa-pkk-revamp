<?php

namespace App\Filament\Resources\PendaftaranKegiatanResource\Pages;

use App\Filament\Resources\PendaftaranKegiatanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendaftaranKegiatan extends ListRecords
{
    protected static string $resource = PendaftaranKegiatanResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()->label('Tambah Pendaftaran')];
    }
}
