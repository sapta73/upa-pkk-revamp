<?php
namespace App\Filament\Resources;

use App\Filament\Resources\BkResource\Pages;
use Modules\BimbinganKonseling\Models\Konselor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BkResource extends Resource
{
    protected static ?string $model = Konselor::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Bimbingan Konseling';
    protected static ?string $navigationLabel = 'Konselor';
    protected static ?string $modelLabel = 'Konselor';
    protected static ?string $pluralModelLabel = 'Konselor';

    // RBAC: hanya admin yang boleh mengelola konselor
    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('id_konselor')->required()->label('ID Konselor'),
            Forms\Components\TextInput::make('nama')->required()->label('Nama'),
            Forms\Components\TextInput::make('nip')->label('NIP'),
            Forms\Components\TextInput::make('spesialisasi')->required()->label('Spesialisasi'),
            Forms\Components\Textarea::make('bio')->label('Biografi'),
            Forms\Components\FileUpload::make('foto')->image()->label('Foto'),
            Forms\Components\TextInput::make('nomor_hp')->label('Nomor HP'),
            Forms\Components\TextInput::make('email')->email()->label('Email'),
            Forms\Components\Toggle::make('status_aktif')->label('Status Aktif')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id_konselor')->label('ID Konselor')->searchable(),
            Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable(),
            Tables\Columns\TextColumn::make('spesialisasi')->label('Spesialisasi'),
            Tables\Columns\IconColumn::make('status_aktif')->boolean()->label('Aktif'),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Dibuat'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKonselors::route('/'),
            'create' => Pages\CreateKonselor::route('/create'),
            'edit' => Pages\EditKonselor::route('/{record}/edit'),
        ];
    }
}
