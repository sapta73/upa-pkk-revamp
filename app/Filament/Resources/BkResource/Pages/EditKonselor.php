<?php
namespace App\Filament\Resources\BkResource\Pages;
use App\Filament\Resources\BkResource;
use App\Filament\Resources\BkResource\Concerns\MengelolaAkunKonselor;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKonselor extends EditRecord
{
    use MengelolaAkunKonselor;

    protected static string $resource = BkResource::class;

    protected function beforeSave(): void
    {
        $this->periksaAkunKonselor($this->record->getKey());
    }

    protected function afterSave(): void
    {
        $this->tautkanAkunKonselor();
        $this->sinkronkanDataKonselor();
    }

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
        return 'Data konselor berhasil diperbarui.';
    }
}
