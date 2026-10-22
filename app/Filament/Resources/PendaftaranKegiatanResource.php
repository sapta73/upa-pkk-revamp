<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendaftaranKegiatanResource\Pages;
use App\Models\PendaftaranKegiatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PendaftaranKegiatanResource extends Resource
{
    protected static ?string $model = PendaftaranKegiatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $slug = 'pendaftaran-kegiatan';

    protected static ?string $navigationGroup = 'Karier';

    protected static ?string $navigationLabel = 'Pendaftaran Kegiatan';

    protected static ?string $modelLabel = 'Pendaftaran Kegiatan';

    protected static ?string $pluralModelLabel = 'Pendaftaran Kegiatan';

    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Peserta')
                ->schema([
                    Forms\Components\Select::make('kegiatan_id')
                        ->label('Kegiatan')
                        ->relationship('kegiatan', 'judul')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\TextInput::make('nama')->label('Nama')->required()->maxLength(255),
                    Forms\Components\TextInput::make('email')->label('Email')->email()->required()->maxLength(255),
                    Forms\Components\TextInput::make('nomor_hp')->label('Nomor HP')->required()->maxLength(20),
                    Forms\Components\TextInput::make('instansi')->label('Instansi')->maxLength(255),
                ])->columns(2),

            Forms\Components\Section::make('Status')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->label('Status Pendaftaran')
                        ->options([
                            'menunggu' => 'Menunggu',
                            'diterima' => 'Diterima',
                            'ditolak' => 'Ditolak',
                        ])
                        ->default('menunggu')
                        ->required()
                        ->native(false),
                    Forms\Components\Select::make('status_bayar')
                        ->label('Status Pembayaran')
                        ->options([
                            'gratis' => 'Gratis',
                            'menunggu' => 'Menunggu Verifikasi',
                            'lunas' => 'Lunas',
                        ])
                        ->default('gratis')
                        ->required()
                        ->native(false),
                    Forms\Components\FileUpload::make('bukti_bayar')
                        ->label('Bukti Bayar')
                        ->disk('public')
                        ->directory('bukti-bayar')
                        ->maxSize(2048)
                        ->openable()
                        ->downloadable(),
                    Forms\Components\Select::make('status_hadir')
                        ->label('Kehadiran')
                        ->options([
                            'belum' => 'Belum Hadir',
                            'hadir' => 'Hadir',
                            'tidak_hadir' => 'Tidak Hadir',
                        ])
                        ->default('belum')
                        ->required()
                        ->native(false),
                    Forms\Components\Textarea::make('catatan')->label('Catatan')->rows(3),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('kegiatan.judul')->label('Kegiatan')->searchable()->limit(35),
            Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable(),
            Tables\Columns\TextColumn::make('email')->label('Email')->searchable()->toggleable(),
            Tables\Columns\BadgeColumn::make('status')
                ->label('Status')
                ->colors(['warning' => 'menunggu', 'success' => 'diterima', 'danger' => 'ditolak'])
                ->formatStateUsing(fn (PendaftaranKegiatan $record): string => $record->label_status),
            Tables\Columns\BadgeColumn::make('status_bayar')
                ->label('Bayar')
                ->colors(['secondary' => 'gratis', 'warning' => 'menunggu', 'success' => 'lunas'])
                ->formatStateUsing(fn (PendaftaranKegiatan $record): string => $record->label_bayar),
            Tables\Columns\BadgeColumn::make('status_hadir')
                ->label('Hadir')
                ->colors(['secondary' => 'belum', 'success' => 'hadir', 'danger' => 'tidak_hadir'])
                ->formatStateUsing(fn (PendaftaranKegiatan $record): string => $record->label_hadir),
            Tables\Columns\TextColumn::make('created_at')->label('Daftar')->dateTime('d M Y H:i')->sortable(),
        ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('kegiatan_id')->label('Kegiatan')->relationship('kegiatan', 'judul')->searchable(),
                Tables\Filters\SelectFilter::make('status')->label('Status')->options([
                    'menunggu' => 'Menunggu',
                    'diterima' => 'Diterima',
                    'ditolak' => 'Ditolak',
                ]),
                Tables\Filters\SelectFilter::make('status_bayar')->label('Pembayaran')->options([
                    'gratis' => 'Gratis',
                    'menunggu' => 'Menunggu Verifikasi',
                    'lunas' => 'Lunas',
                ]),
                Tables\Filters\SelectFilter::make('status_hadir')->label('Kehadiran')->options([
                    'belum' => 'Belum Hadir',
                    'hadir' => 'Hadir',
                    'tidak_hadir' => 'Tidak Hadir',
                ]),
            ])
            ->actions([
                Tables\Actions\Action::make('verifikasi_lunas')
                    ->label('Verifikasi Lunas')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn (PendaftaranKegiatan $record): bool => $record->status_bayar !== 'lunas')
                    ->action(fn (PendaftaranKegiatan $record) => $record->update(['status_bayar' => 'lunas'])),
                Tables\Actions\Action::make('tandai_hadir')
                    ->label('Tandai Hadir')
                    ->icon('heroicon-o-user-check')
                    ->color('success')
                    ->visible(fn (PendaftaranKegiatan $record): bool => $record->status_hadir !== 'hadir')
                    ->action(fn (PendaftaranKegiatan $record) => $record->update(['status_hadir' => 'hadir'])),
                Tables\Actions\EditAction::make()->label('Edit'),
                Tables\Actions\DeleteAction::make()->label('Hapus'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendaftaranKegiatan::route('/'),
            'create' => Pages\CreatePendaftaranKegiatan::route('/create'),
            'edit' => Pages\EditPendaftaranKegiatan::route('/{record}/edit'),
        ];
    }
}
