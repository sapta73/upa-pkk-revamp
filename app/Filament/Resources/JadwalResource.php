<?php
namespace App\Filament\Resources;

use App\Filament\Resources\JadwalResource\Pages;
use Modules\BimbinganKonseling\Models\Jadwal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JadwalResource extends Resource
{
    protected static ?string $model = Jadwal::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'Bimbingan Konseling';

    protected static ?string $navigationLabel = 'Jadwal';

    protected static ?string $modelLabel = 'Jadwal';

    protected static ?string $pluralModelLabel = 'Jadwal';

    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Jadwal Konselor')
                ->description('Slot waktu yang bisa dipilih mahasiswa saat booking.')
                ->schema([
                    Forms\Components\Select::make('konselor_id')
                        ->label('Konselor')
                        ->relationship('konselor', 'nama')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\Select::make('hari')
                        ->label('Hari')
                        ->options([
                            'senin' => 'Senin',
                            'selasa' => 'Selasa',
                            'rabu' => 'Rabu',
                            'kamis' => 'Kamis',
                            'jumat' => 'Jumat',
                            'sabtu' => 'Sabtu',
                        ])
                        ->native(false)
                        ->required(),
                    Forms\Components\TimePicker::make('jam_mulai')
                        ->label('Jam Mulai')
                        ->seconds(false)
                        ->required(),
                    Forms\Components\TimePicker::make('jam_selesai')
                        ->label('Jam Selesai')
                        ->seconds(false)
                        ->required()
                        ->after('jam_mulai'),
                    Forms\Components\TextInput::make('kuota')
                        ->label('Kuota per Sesi')
                        ->numeric()
                        ->minValue(1)
                        ->default(1)
                        ->required(),
                    Forms\Components\Toggle::make('status_aktif')
                        ->label('Status Aktif')
                        ->default(true)
                        ->helperText('Nonaktifkan jika slot ini tidak dipakai lagi.'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('konselor.nama')->label('Konselor')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('hari')
                ->label('Hari')
                ->formatStateUsing(fn (string $state): string => ucfirst($state))
                ->sortable(),
            Tables\Columns\TextColumn::make('jam_mulai')->label('Jam Mulai')->time('H:i'),
            Tables\Columns\TextColumn::make('jam_selesai')->label('Jam Selesai')->time('H:i'),
            Tables\Columns\TextColumn::make('kuota')->label('Kuota')->numeric()->sortable(),
            Tables\Columns\IconColumn::make('status_aktif')->boolean()->label('Aktif'),
        ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('konselor_id')
                    ->label('Konselor')
                    ->relationship('konselor', 'nama'),
                Tables\Filters\SelectFilter::make('hari')
                    ->label('Hari')
                    ->options([
                        'senin' => 'Senin',
                        'selasa' => 'Selasa',
                        'rabu' => 'Rabu',
                        'kamis' => 'Kamis',
                        'jumat' => 'Jumat',
                        'sabtu' => 'Sabtu',
                    ]),
                Tables\Filters\TernaryFilter::make('status_aktif')->label('Status Aktif'),
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
            'index' => Pages\ListJadwals::route('/'),
            'create' => Pages\CreateJadwal::route('/create'),
            'edit' => Pages\EditJadwal::route('/{record}/edit'),
        ];
    }
}
