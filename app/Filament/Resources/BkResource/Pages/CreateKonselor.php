<?php
namespace App\Filament\Resources\BkResource\Pages;
use App\Filament\Resources\BkResource;
use App\Filament\Resources\BkResource\Concerns\MengelolaAkunKonselor;
use Filament\Resources\Pages\CreateRecord;

class CreateKonselor extends CreateRecord
{
    use MengelolaAkunKonselor;

    protected static string $resource = BkResource::class;

    protected function beforeCreate(): void
    {
        $this->periksaAkunKonselor();
    }

    protected function afterCreate(): void
    {
        $this->tautkanAkunKonselor();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data konselor berhasil ditambahkan.';
    }
}
