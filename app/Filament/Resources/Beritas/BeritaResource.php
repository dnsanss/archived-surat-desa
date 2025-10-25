<?php

namespace App\Filament\Resources\Beritas;

use BackedEnum;
use App\Models\Berita;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\View;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\Beritas\Pages\EditBerita;
use App\Filament\Resources\Beritas\Pages\ListBeritas;
use App\Filament\Resources\Beritas\Pages\CreateBerita;
use App\Filament\Resources\Beritas\Schemas\BeritaForm;
use App\Filament\Resources\Beritas\Tables\BeritasTable;
use Filament\Forms\Components\RichEditor;

class BeritaResource extends Resource
{
    protected static ?string $model = Berita::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Newspaper;

    protected static ?string $recordTitleAttribute = 'Berita';
    protected static ?string $navigationLabel = 'Berita Desa';
    public static function getNavigationLabel(): string
    {
        return 'Berita Desa';
    }
    protected static ?string $pluralLabel = 'Berita Desa';

    // Form Schema
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('judul')
                    ->label('Judul Berita')
                    ->required()
                    ->maxLength(150),

                RichEditor::make('isi')
                    ->label('Isi Berita')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'bulletList',
                        'orderedList',
                        'link',
                    ])
                    ->extraAttributes([
                        'style' => 'max-height:200px; min-height:200px; overflow-y:auto;',
                    ])
                    ->required(),

                FileUpload::make('gambar')
                    ->label('Gambar Berita')
                    ->disk('public')
                    ->directory('berita')
                    ->image()
                    ->imageEditor()
                    ->maxSize(2048)
                    ->nullable(),

                DatePicker::make('tanggal_publikasi')
                    ->label('Tanggal Publikasi')
                    ->default(now())
                    ->required(),

                TextInput::make('penulis')
                    ->default('Admin Desa Karangasem')
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->disk('public'),

                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable(),

                TextColumn::make('tanggal_publikasi')
                    ->label('Tanggal Publikasi')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('penulis')
                    ->label('Penulis'),
            ])
            ->defaultSort('tanggal_publikasi', 'desc')
            ->recordUrl(fn() => null)
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
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
            'index' => ListBeritas::route('/'),
            'create' => CreateBerita::route('/create'),
            'edit' => EditBerita::route('/{record}/edit'),
        ];
    }
}
