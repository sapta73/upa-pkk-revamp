<?php
namespace App\Filament\Resources;

use App\Filament\Resources\BeritaResource\Pages;
use Modules\Berita\Models\Berita;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BeritaResource extends Resource
{
    protected static ?string $model = Berita::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?string $label = 'Berita';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('judul')->required()->label('Judul'),
            Forms\Components\TextInput::make('slug')->required()->label('Slug'),
            Forms\Components\RichEditor::make('isi')->required()->label('Isi'),
            Forms\Components\FileUpload::make('gambar')->image()->label('Gambar'),
            Forms\Components\TextInput::make('penulis')->label('Penulis'),
            Forms\Components\Select::make('status')->options(['draft' => 'Draft', 'terbit' => 'Terbit'])->required()->label('Status'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('judul')->label('Judul')->searchable()->limit(50),
            Tables\Columns\TextColumn::make('penulis')->label('Penulis'),
            Tables\Columns\BadgeColumn::make('status')->colors(['warning' => 'draft', 'success' => 'terbit'])->label('Status'),
            Tables\Columns\TextColumn::make('created_at')->date()->label('Dibuat'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBeritas::route('/'),
            'create' => Pages\CreateBerita::route('/create'),
            'edit' => Pages\EditBerita::route('/{record}/edit'),
        ];
    }
}
