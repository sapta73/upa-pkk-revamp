<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsahaPmwP2mwResource\Pages;
use App\Models\UsahaPmwP2mw;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class UsahaPmwP2mwResource extends Resource
{
    protected static ?string $model = UsahaPmwP2mw::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Usaha PMW/P2MW';

    protected static ?string $pluralLabel = 'Usaha PMW/P2MW';

    protected static ?string $modelLabel = 'Usaha';

    protected static ?string $slug = 'usaha-pmw-p2mw';

    protected static ?string $navigationGroup = 'Wirausaha';

    protected static ?int $navigationSort = 1;

    // RBAC: hanya admin yang boleh mengelola usaha
    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Usaha')
                    ->description('Data lengkap usaha mahasiswa')
                    ->schema([
                        TextInput::make('nama_usaha')
                            ->label('Nama Usaha')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Budidaya Jamur Tiram'),
                        TextInput::make('nama_pemilik')
                            ->label('Nama Pemilik')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Nama lengkap mahasiswa'),
                        TextInput::make('nim')
                            ->label('NIM')
                            ->maxLength(20)
                            ->placeholder('Contoh: 2012011001'),
                        Select::make('program')
                            ->label('Program')
                            ->options([
                                'pmw' => 'PMW (Program Mahasiswa Wirausaha)',
                                'p2mw' => 'P2MW (Program Pengembangan Mahasiswa Wirausaha)',
                            ])
                            ->required()
                            ->native(false),
                        TextInput::make('jenis_usaha')
                            ->label('Jenis Usaha')
                            ->maxLength(255)
                            ->placeholder('Contoh: Kuliner, Fashion, Agribisnis'),
                        TextInput::make('tahun_kegiatan')
                            ->label('Tahun Kegiatan')
                            ->numeric()
                            ->minValue(2020)
                            ->maxValue(2030)
                            ->placeholder('Contoh: 2026'),
                        TextInput::make('modal_dana')
                            ->label('Modal/Dana (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->placeholder('Contoh: 5000000'),
                        Textarea::make('deskripsi')
                            ->label('Deskripsi Usaha')
                            ->rows(4)
                            ->placeholder('Jelaskan secara singkat tentang usaha ini...'),
                    ])->columns(2),

                Forms\Components\Section::make('Dokumen & Status')
                    ->schema([
                        FileUpload::make('foto')
                            ->label('Foto Usaha')
                            ->image()
                            ->directory('usaha/foto')
                            ->maxSize(10240)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Maksimal 10MB. Format: JPG, PNG, WebP'),
                        FileUpload::make('sk_pendanaan')
                            ->label('SK Pendanaan (PDF)')
                            ->directory('usaha/sk')
                            ->maxSize(15360)
                            ->acceptedFileTypes(['application/pdf'])
                            ->helperText('Maksimal 15MB. Format: PDF'),
                        Toggle::make('status_aktif')
                            ->label('Status Aktif')
                            ->default(true)
                            ->helperText('Nonaktifkan jika usaha sudah tidak berjalan'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_usaha')
                    ->label('Nama Usaha')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('nama_pemilik')
                    ->label('Pemilik')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nim')
                    ->label('NIM')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('program')
                    ->label('Program')
                    ->colors([
                        'success' => 'pmw',
                        'warning' => 'p2mw',
                    ])
                    ->formatStateUsing(fn(string $state): string => strtoupper($state)),
                TextColumn::make('jenis_usaha')
                    ->label('Jenis Usaha')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('tahun_kegiatan')
                    ->label('Tahun')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('modal_dana')
                    ->label('Modal')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('status_aktif')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('program')
                    ->options([
                        'pmw' => 'PMW',
                        'p2mw' => 'P2MW',
                    ]),
                SelectFilter::make('tahun_kegiatan')
                    ->label('Tahun')
                    ->options(
                        UsahaPmwP2mw::select('tahun_kegiatan')
                            ->distinct()
                            ->whereNotNull('tahun_kegiatan')
                            ->orderBy('tahun_kegiatan', 'desc')
                            ->pluck('tahun_kegiatan', 'tahun_kegiatan')
                            ->toArray()
                    ),
                Tables\Filters\TernaryFilter::make('status_aktif')
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
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsahaPmwP2mw::route('/'),
            'create' => Pages\CreateUsahaPmwP2mw::route('/create'),
            'edit' => Pages\EditUsahaPmwP2mw::route('/{record}/edit'),
        ];
    }
}
