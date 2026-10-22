<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenggunaResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PenggunaResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $slug = 'pengguna';

    protected static ?string $navigationGroup = 'Pengguna';

    protected static ?string $navigationLabel = 'Pengguna';

    protected static ?string $modelLabel = 'Pengguna';

    protected static ?string $pluralModelLabel = 'Pengguna';

    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Akun')
                ->schema([
                    Forms\Components\TextInput::make('name')->label('Nama')->required()->maxLength(255),
                    Forms\Components\TextInput::make('email')->label('Email')->email()->required()->unique(ignoreRecord: true)->maxLength(255),
                    Forms\Components\Select::make('role')
                        ->label('Role')
                        ->options([
                            'mahasiswa' => 'Mahasiswa',
                            'dosen' => 'Dosen',
                            'tendik' => 'Tendik',
                            'konselor' => 'Konselor',
                            'admin' => 'Admin',
                        ])
                        ->required()
                        ->native(false)
                        ->helperText('Untuk akun konselor, gunakan menu Bimbingan Konseling > Konselor agar data konselor ikut terhubung.'),
                    Forms\Components\TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->revealable()
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->dehydrated(fn ($state): bool => filled($state))
                        ->maxLength(255),
                ])->columns(2),

            Forms\Components\Section::make('Identitas')
                ->schema([
                    Forms\Components\TextInput::make('nim')
                        ->label('NIM')
                        ->visible(fn (Forms\Get $get): bool => $get('role') === 'mahasiswa')
                        ->required(fn (Forms\Get $get): bool => $get('role') === 'mahasiswa')
                        ->unique(ignoreRecord: true)
                        ->maxLength(20),
                    Forms\Components\TextInput::make('prodi')
                        ->label('Program Studi')
                        ->visible(fn (Forms\Get $get): bool => $get('role') === 'mahasiswa')
                        ->required(fn (Forms\Get $get): bool => $get('role') === 'mahasiswa')
                        ->maxLength(100),
                    Forms\Components\TextInput::make('nip')
                        ->label('NIP')
                        ->visible(fn (Forms\Get $get): bool => in_array($get('role'), ['dosen', 'tendik']))
                        ->required(fn (Forms\Get $get): bool => in_array($get('role'), ['dosen', 'tendik']))
                        ->unique(ignoreRecord: true)
                        ->maxLength(30),
                    Forms\Components\TextInput::make('unit')
                        ->label('Unit')
                        ->visible(fn (Forms\Get $get): bool => in_array($get('role'), ['dosen', 'tendik']))
                        ->required(fn (Forms\Get $get): bool => in_array($get('role'), ['dosen', 'tendik']))
                        ->maxLength(100),
                    Forms\Components\TextInput::make('nomor_hp')
                        ->label('Nomor HP')
                        ->visible(fn (Forms\Get $get): bool => in_array($get('role'), ['mahasiswa', 'konselor']))
                        ->maxLength(15),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
            Tables\Columns\BadgeColumn::make('role')
                ->label('Role')
                ->colors([
                    'primary' => 'mahasiswa',
                    'success' => 'dosen',
                    'warning' => 'tendik',
                    'info' => 'konselor',
                    'danger' => 'admin',
                ])
                ->formatStateUsing(fn (string $state): string => ucfirst($state)),
            Tables\Columns\TextColumn::make('nim')->label('NIM')->placeholder('-')->toggleable(),
            Tables\Columns\TextColumn::make('nip')->label('NIP')->placeholder('-')->toggleable(),
            Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime('d M Y')->sortable(),
        ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('role')->label('Role')->options([
                    'mahasiswa' => 'Mahasiswa',
                    'dosen' => 'Dosen',
                    'tendik' => 'Tendik',
                    'konselor' => 'Konselor',
                    'admin' => 'Admin',
                ]),
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
            'index' => Pages\ListPengguna::route('/'),
            'create' => Pages\CreatePengguna::route('/create'),
            'edit' => Pages\EditPengguna::route('/{record}/edit'),
        ];
    }
}
