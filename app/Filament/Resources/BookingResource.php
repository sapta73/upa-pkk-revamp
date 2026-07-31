<?php
namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use Modules\BimbinganKonseling\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Bimbingan Konseling';
    protected static ?string $navigationLabel = 'Pemesanan';
    protected static ?string $modelLabel = 'Pemesanan';
    protected static ?string $pluralModelLabel = 'Pemesanan';

    // RBAC: hanya admin yang boleh mengelola pemesanan
    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('konselor_id')->relationship('konselor', 'nama')->required()->label('Konselor'),
            Forms\Components\TextInput::make('nama_mahasiswa')->required()->label('Nama Mahasiswa'),
            Forms\Components\TextInput::make('nim')->required()->label('NIM'),
            Forms\Components\TextInput::make('prodi')->required()->label('Prodi'),
            Forms\Components\TextInput::make('nomor_hp')->required()->label('No HP'),
            Forms\Components\TextInput::make('email')->email()->required()->label('Email'),
            Forms\Components\DatePicker::make('tanggal')->required()->label('Tanggal'),
            Forms\Components\TimePicker::make('jam_sesi')->required()->label('Jam Sesi'),
            Forms\Components\Textarea::make('deskripsi_masalah')->label('Deskripsi Masalah'),
            Forms\Components\Select::make('status')->options([
                'menunggu' => 'Menunggu', 'disetujui' => 'Disetujui',
                'ditolak' => 'Ditolak', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'
            ])->required()->label('Status'),
            Forms\Components\TextInput::make('link_meeting')->label('Link Meeting'),
            Forms\Components\Textarea::make('catatan_konselor')->label('Catatan Konselor'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('kode_booking')->label('Kode')->searchable(),
            Tables\Columns\TextColumn::make('nama_mahasiswa')->label('Mahasiswa')->searchable(),
            Tables\Columns\TextColumn::make('konselor.nama')->label('Konselor'),
            Tables\Columns\TextColumn::make('tanggal')->date()->label('Tanggal'),
            Tables\Columns\TextColumn::make('jam_sesi')->time()->label('Jam'),
            Tables\Columns\BadgeColumn::make('status')->colors([
                'warning' => 'menunggu', 'success' => 'disetujui',
                'danger' => 'ditolak', 'primary' => 'selesai', 'secondary' => 'dibatalkan'
            ])->label('Status'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
