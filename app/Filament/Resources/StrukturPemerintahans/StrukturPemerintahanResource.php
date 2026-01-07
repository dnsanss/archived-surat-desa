<?php

namespace App\Filament\Resources\StrukturPemerintahans;

use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use App\Models\StrukturPemerintahan;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\StrukturPemerintahans\Pages\EditStrukturPemerintahan;
use App\Filament\Resources\StrukturPemerintahans\Pages\ListStrukturPemerintahans;
use App\Filament\Resources\StrukturPemerintahans\Pages\CreateStrukturPemerintahan;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;

class StrukturPemerintahanResource extends Resource
{
    protected static ?string $model = StrukturPemerintahan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice2;

    public static function getNavigationGroup(): ?string
    {
        return 'Data Desa';   // Grup menu untuk sidebar
    }

    protected static ?string $navigationLabel = 'Struktur Pemerintahan';
    protected static ?string $pluralLabel = 'Struktur Pemerintahan';
    protected static ?string $recordTitleAttribute = 'Struktur Pemerintahan';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('nama')->label('Nama')->required(),
            TextInput::make('jabatan')->label('Jabatan')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->label('Nama')->searchable(),
                TextColumn::make('jabatan')->label('Jabatan')->searchable(),
            ])
            ->defaultSort('nama', 'asc')
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make('Hapus')
                    ->icon('heroicon-o-trash')
                    ->label('Hapus Terpilih')
                    ->successNotificationTitle('Data terpilih berhasil dihapus.'),
            ])
            //untuk menonaktifkan klik pada baris tabel agar tidak membuka halaman detail
            ->recordUrl(fn() => null)
            ->recordAction(null);
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
            'index' => ListStrukturPemerintahans::route('/'),
            'create' => CreateStrukturPemerintahan::route('/create'),
            'edit' => EditStrukturPemerintahan::route('/{record}/edit'),
        ];
    }
}
