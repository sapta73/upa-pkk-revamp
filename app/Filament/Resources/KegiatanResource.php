<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KegiatanResource\Pages;
use App\Models\Kegiatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KegiatanResource extends Resource
{
    protected static ?string $model = Kegiatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $slug = 'kegiatan';

    protected static ?string $navigationGroup = 'Karier';

    protected static ?string $navigationLabel = 'Kegiatan';

    protected static ?string $modelLabel = 'Kegiatan';

    protected static ?string $pluralModelLabel = 'Kegiatan';

    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Kegiatan')
                ->schema([
                    Forms\Components\Select::make('jenis')
                        ->label('Jenis')
                        ->options([
                            'workshop' => 'Workshop',
                            'seminar' => 'Seminar',
                        ])
                        ->required()
                        ->native(false),
                    Forms\Components\TextInput::make('judul')->label('Judul')->required()->maxLength(255),
                    Forms\Components\TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->helperText('Dipakai di URL, contoh: cooking-class-upa-pkk.'),
                    Forms\Components\Textarea::make('deskripsi')->label('Deskripsi')->required()->rows(6),
                    Forms\Components\FileUpload::make('gambar')
                        ->label('Gambar')
                        ->image()
                        ->disk('public')
                        ->directory('kegiatan')
                        ->maxSize(2048),
                ])->columns(2),

            Forms\Components\Section::make('Pelaksanaan')
                ->schema([
                    Forms\Components\DatePicker::make('tanggal_mulai')->label('Tanggal Mulai')->required(),
                    Forms\Components\DatePicker::make('tanggal_selesai')->label('Tanggal Selesai')->afterOrEqual('tanggal_mulai'),
                    Forms\Components\TimePicker::make('jam_mulai')->label('Jam Mulai')->seconds(false),
                    Forms\Components\TimePicker::make('jam_selesai')->label('Jam Selesai')->seconds(false),
                    Forms\Components\TextInput::make('lokasi')->label('Lokasi')->maxLength(255),
                    Forms\Components\TextInput::make('kuota')
                        ->label('Kuota')
                        ->numeric()
                        ->minValue(0)
                        ->default(0)
                        ->helperText('Isi 0 jika tidak dibatasi.'),
                ])->columns(2),

            Forms\Components\Section::make('Pendaftaran')
                ->schema([
                    Forms\Components\TextInput::make('harga')
                        ->label('Harga')
                        ->numeric()
                        ->minValue(0)
                        ->default(0)
                        ->prefix('Rp')
                        ->helperText('Isi 0 untuk gratis.'),
                    Forms\Components\Textarea::make('instruksi_bayar')
                        ->label('Instruksi Pembayaran')
                        ->rows(3)
                        ->helperText('Contoh: transfer ke BNI 1234567890 a.n. UPA PKK UBB.'),
                    Forms\Components\Toggle::make('wajib')->label('Wajib Diikuti'),
                    Forms\Components\Toggle::make('status_aktif')->label('Status Aktif')->default(true),
                ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\BadgeColumn::make('jenis')
                ->label('Jenis')
                ->colors([
                    'primary' => 'workshop',
                    'success' => 'seminar',
                ])
                ->formatStateUsing(fn (string $state): string => ucfirst($state)),
            Tables\Columns\TextColumn::make('judul')->label('Judul')->searchable()->sortable()->limit(45),
            Tables\Columns\TextColumn::make('tanggal_mulai')->label('Tanggal')->date('d M Y')->sortable(),
            Tables\Columns\TextColumn::make('harga')->label('Harga')->money('IDR', locale: 'id'),
            Tables\Columns\TextColumn::make('kuota')->label('Kuota')->numeric()->sortable(),
            Tables\Columns\TextColumn::make('pendaftaran_count')->counts('pendaftaran')->label('Pendaftar'),
            Tables\Columns\IconColumn::make('wajib')->boolean()->label('Wajib'),
            Tables\Columns\IconColumn::make('status_aktif')->boolean()->label('Aktif'),
        ])
            ->defaultSort('tanggal_mulai', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('jenis')->label('Jenis')->options([
                    'workshop' => 'Workshop',
                    'seminar' => 'Seminar',
                ]),
                Tables\Filters\TernaryFilter::make('status_aktif')->label('Status Aktif'),
                Tables\Filters\TernaryFilter::make('wajib')->label('Wajib Diikuti'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit'),
                Tables\Actions\DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKegiatan::route('/'),
            'create' => Pages\CreateKegiatan::route('/create'),
            'edit' => Pages\EditKegiatan::route('/{record}/edit'),
        ];
    }
}
