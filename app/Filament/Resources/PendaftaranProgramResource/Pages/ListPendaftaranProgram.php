<?php

namespace App\Filament\Resources\PendaftaranProgramResource\Pages;

use App\Filament\Resources\PendaftaranProgramResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendaftaranProgram extends ListRecords
{
    protected static string $resource = PendaftaranProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()->label('Tambah Pendaftaran')];
    }
}
