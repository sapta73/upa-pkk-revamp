<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LowonganKerjaResource\Pages;
use App\Models\LowonganKerja;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class LowonganKerjaResource extends Resource
{
    protected static ?string $model = LowonganKerja::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Lowongan Kerja';

    protected static ?string $pluralLabel = 'Lowongan Kerja';

    protected static ?string $modelLabel = 'Lowongan Kerja';

    protected static ?string $slug = 'lowongan-kerja';

    protected static ?string $navigationGroup = 'Karir';

    protected static ?int $navigationSort = 1;

    // RBAC: hanya admin yang boleh mengelola lowongan
    public static function canViewAny(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = app('auth')->guard()->user();

        return $user?->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Lowongan')
                    ->description('Data utama lowongan pekerjaan')
                    ->schema([
                        TextInput::make('judul')
                            ->label('Judul Lowongan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Staf Administrasi Keuangan'),
                        TextInput::make('perusahaan')
                            ->label('Perusahaan / Instansi')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: PT Bangka Digital Indonesia'),
                        TextInput::make('posisi')
                            ->label('Posisi / Jabatan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Staff Administrasi'),
                        TextInput::make('lokasi')
                            ->label('Lokasi')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Pangkalpinang, Bangka Belitung'),
                        Select::make('tipe_pekerjaan')
                            ->label('Tipe Pekerjaan')
                            ->options([
                                'full_time' => 'Full Time',
                                'part_time' => 'Part Time',
                                'magang' => 'Magang (Internship)',
                                'kontrak' => 'Kontrak',
                            ])
                            ->default('full_time')
                            ->required()
                            ->native(false),
                        TextInput::make('gaji')
                            ->label('Gaji')
                            ->maxLength(100)
                            ->placeholder('Contoh: Rp 3.500.000 - Rp 5.000.000'),
                        TextInput::make('kuota')
                            ->label('Kuota (opsional)')
                            ->numeric()
                            ->minValue(1)
                            ->helperText('Jumlah posisi yang dibutuhkan'),
                    ])->columns(2),

                Forms\Components\Section::make('Detail & Persyaratan')
                    ->schema([
                        Textarea::make('deskripsi')
                            ->label('Deskripsi Pekerjaan')
                            ->required()
                            ->rows(6)
                            ->placeholder('Jelaskan tanggung jawab dan detail pekerjaan...'),
                        Textarea::make('persyaratan')
                            ->label('Persyaratan / Kualifikasi')
                            ->rows(6)
                            ->placeholder('Tuliskan syarat-syarat pelamar, satu per baris...'),
                    ])->columns(1),

                Forms\Components\Section::make('Pendaftaran & Status')
                    ->schema([
                        DatePicker::make('batas_lamaran')
                            ->label('Batas Lamaran')
                            ->minDate(today())
                            ->helperText('Kosongkan jika lowongan berlaku hingga ada keputusan'),
                        TextInput::make('link_pendaftaran')
                            ->label('Link Pendaftaran')
                            ->url()
                            ->placeholder('https://contoh.com/daftar'),
                        TextInput::make('kontak')
                            ->label('Kontak (Email/HP)')
                            ->maxLength(255)
                            ->placeholder('Contoh: hrd@perusahaan.com / 0812-3456-7890'),
                        Toggle::make('status_aktif')
                            ->label('Status Aktif')
                            ->default(true)
                            ->helperText('Nonaktifkan jika lowongan sudah ditutup'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(40),
                TextColumn::make('perusahaan')
                    ->label('Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                TextColumn::make('posisi')
                    ->label('Posisi')
                    ->searchable()
                    ->toggleable(),
                BadgeColumn::make('tipe_pekerjaan')
                    ->label('Tipe')
                    ->colors([
                        'primary' => 'full_time',
                        'success' => 'part_time',
                        'warning' => 'magang',
                        'danger' => 'kontrak',
                    ])
                    ->formatStateUsing(fn (LowonganKerja $record): string => $record->label_tipe),
                TextColumn::make('lokasi')
                    ->label('Lokasi')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('batas_lamaran')
                    ->label('Batas Lamaran')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('status_aktif')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('tipe_pekerjaan')
                    ->label('Tipe Pekerjaan')
                    ->options([
                        'full_time' => 'Full Time',
                        'part_time' => 'Part Time',
                        'magang' => 'Magang',
                        'kontrak' => 'Kontrak',
                    ]),
                TernaryFilter::make('status_aktif')
                    ->label('Status Aktif'),
            ])
            ->actions([
                EditAction::make()
                    ->label('Edit'),
                DeleteAction::make()
                    ->label('Hapus'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLowonganKerja::route('/'),
            'create' => Pages\CreateLowonganKerja::route('/create'),
            'edit' => Pages\EditLowonganKerja::route('/{record}/edit'),
        ];
    }
}
