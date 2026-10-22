<?php
namespace App\Filament\Resources;

use App\Filament\Resources\BkResource\Pages;
use Modules\BimbinganKonseling\Models\Konselor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
            Forms\Components\Section::make('Data Konselor')
                ->description('Informasi profil konselor yang tampil di halaman publik.')
                ->schema([
                    Forms\Components\TextInput::make('id_konselor')->required()->label('ID Konselor'),
                    Forms\Components\TextInput::make('nama')->required()->label('Nama'),
                    Forms\Components\TextInput::make('nip')->label('NIP'),
                    Forms\Components\TextInput::make('spesialisasi')->required()->label('Spesialisasi'),
                    Forms\Components\Textarea::make('bio')->label('Biografi')->rows(4),
                    Forms\Components\FileUpload::make('foto')->image()->label('Foto'),
                    Forms\Components\TextInput::make('nomor_hp')->label('Nomor HP'),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->label('Email')
                        ->required(fn (Forms\Get $get): bool => filled($get('password_akun')) || filled($get('user_id')))
                        ->helperText('Email ini dipakai sebagai akun login konselor.'),
                    Forms\Components\Toggle::make('status_aktif')->label('Status Aktif')->default(true),
                ])->columns(2),

            Forms\Components\Section::make('Akun Login Konselor')
                ->description('Akun ini dipakai konselor untuk masuk ke dashboard konselor.')
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->label('Akun Login Terhubung')
                        ->relationship(
                            'user',
                            'email',
                            modifyQueryUsing: fn (Builder $query) => $query->where('role', 'konselor')
                        )
                        ->searchable()
                        ->preload()
                        ->placeholder('Belum terhubung')
                        ->visible(fn (string $operation): bool => $operation === 'edit')
                        ->helperText('Pilih akun yang sudah ada, atau biarkan kosong untuk membuat akun baru dari email konselor.'),
                    Forms\Components\TextInput::make('password_akun')
                        ->label('Password Akun Login')
                        ->password()
                        ->revealable()
                        ->dehydrated(false)
                        ->maxLength(255)
                        ->helperText('Isi untuk membuat akun baru atau mereset password. Kosongkan jika tidak diubah.'),
                ])->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id_konselor')->label('ID Konselor')->searchable(),
            Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable(),
            Tables\Columns\TextColumn::make('spesialisasi')->label('Spesialisasi'),
            Tables\Columns\TextColumn::make('user.email')->label('Akun Login')->placeholder('Belum terhubung'),
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
