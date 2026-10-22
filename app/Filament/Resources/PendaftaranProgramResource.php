<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendaftaranProgramResource\Pages;
use App\Models\PendaftaranProgram;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PendaftaranProgramResource extends Resource
{
    protected static ?string $model = PendaftaranProgram::class;

    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch';

    protected static ?string $slug = 'pendaftaran-program';

    protected static ?string $navigationGroup = 'Wirausaha';

    protected static ?string $navigationLabel = 'Pendaftaran Program';

    protected static ?string $modelLabel = 'Pendaftaran Program';

    protected static ?string $pluralModelLabel = 'Pendaftaran Program';

    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Pendaftar')
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->label('Mahasiswa')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\Select::make('program')
                        ->label('Program')
                        ->options([
                            'pmw' => 'PMW',
                            'p2mw' => 'P2MW',
                            'klk' => 'KLK',
                        ])
                        ->required()
                        ->native(false),
                    Forms\Components\TextInput::make('nama_tim')->label('Nama Tim')->required()->maxLength(255),
                    Forms\Components\TextInput::make('ketua')->label('Ketua Tim')->required()->maxLength(255),
                    Forms\Components\Textarea::make('anggota')->label('Anggota')->rows(3)->helperText('Satu nama per baris.'),
                ])->columns(2),

            Forms\Components\Section::make('Usaha')
                ->schema([
                    Forms\Components\TextInput::make('judul_usaha')->label('Judul Usaha')->required()->maxLength(255),
                    Forms\Components\Textarea::make('deskripsi')->label('Deskripsi Usaha')->required()->rows(5),
                    Forms\Components\TextInput::make('link_proposal')->label('Link Proposal')->url()->required()->maxLength(255),
                ])->columns(1),

            Forms\Components\Section::make('Review')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options([
                            'menunggu' => 'Menunggu',
                            'diterima' => 'Diterima',
                            'ditolak' => 'Ditolak',
                        ])
                        ->default('menunggu')
                        ->required()
                        ->native(false),
                    Forms\Components\Textarea::make('catatan_admin')->label('Catatan Admin')->rows(3),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('user.name')->label('Mahasiswa')->searchable(),
            Tables\Columns\BadgeColumn::make('program')
                ->label('Program')
                ->colors(['primary' => 'pmw', 'success' => 'p2mw', 'warning' => 'klk'])
                ->formatStateUsing(fn (PendaftaranProgram $record): string => $record->label_program),
            Tables\Columns\TextColumn::make('nama_tim')->label('Tim')->searchable()->limit(30),
            Tables\Columns\TextColumn::make('judul_usaha')->label('Judul Usaha')->searchable()->limit(40),
            Tables\Columns\BadgeColumn::make('status')
                ->label('Status')
                ->colors(['warning' => 'menunggu', 'success' => 'diterima', 'danger' => 'ditolak'])
                ->formatStateUsing(fn (PendaftaranProgram $record): string => $record->label_status),
            Tables\Columns\TextColumn::make('created_at')->label('Daftar')->dateTime('d M Y H:i')->sortable(),
        ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('program')->label('Program')->options([
                    'pmw' => 'PMW',
                    'p2mw' => 'P2MW',
                    'klk' => 'KLK',
                ]),
                Tables\Filters\SelectFilter::make('status')->label('Status')->options([
                    'menunggu' => 'Menunggu',
                    'diterima' => 'Diterima',
                    'ditolak' => 'Ditolak',
                ]),
            ])
            ->actions([
                Tables\Actions\Action::make('terima')
                    ->label('Terima')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (PendaftaranProgram $record): bool => $record->status !== 'diterima')
                    ->action(fn (PendaftaranProgram $record) => $record->update(['status' => 'diterima'])),
                Tables\Actions\Action::make('tolak')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (PendaftaranProgram $record): bool => $record->status !== 'ditolak')
                    ->action(fn (PendaftaranProgram $record) => $record->update(['status' => 'ditolak'])),
                Tables\Actions\EditAction::make()->label('Edit'),
                Tables\Actions\DeleteAction::make()->label('Hapus'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendaftaranProgram::route('/'),
            'create' => Pages\CreatePendaftaranProgram::route('/create'),
            'edit' => Pages\EditPendaftaranProgram::route('/{record}/edit'),
        ];
    }
}
