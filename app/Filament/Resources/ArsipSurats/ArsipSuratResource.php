<?php

namespace App\Filament\Resources\ArsipSurats;

use BackedEnum;
use App\Models\ArsipSurat;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\ArsipSurats\Pages\EditArsipSurat;
use App\Filament\Resources\ArsipSurats\Pages\ListArsipSurats;
use App\Filament\Resources\ArsipSurats\Pages\CreateArsipSurat;
use App\Filament\Resources\ArsipSuratResource\Pages\ViewArsipSurat;

class ArsipSuratResource extends Resource
{
    protected static ?string $model = ArsipSurat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentArrowUp;

    public static function getNavigationLabel(): string
    {
        return 'Arsip Surat';
    }

    // public static function getNavigationGroup(): string|UnitEnum|null
    // {
    //     return static::$navigationGroup = 'Data Surat';
    // }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('nomor_surat')
                ->label('Nomor Surat')
                ->required()
                ->unique(ignoreRecord: true),

            TextInput::make('nama_surat')
                ->label('Nama Surat')
                ->required(),

            FileUpload::make('dokumen')
                ->label('Upload Dokumen')
                ->disk('local')
                ->directory('arsip-surat')
                ->acceptedFileTypes([
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'text/plain',
                    'text/html',
                    'application/vnd.oasis.opendocument.text',
                ])
                ->visibility('private')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor_surat')->searchable(),
                TextColumn::make('nama_surat')->searchable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i'),
            ])
            ->defaultSort('nomor_surat', 'asc')
            ->recordActions([
                ViewAction::make()
                    ->url(fn($record) => self::getUrl('view', ['record' => $record]))
                    ->openUrlInNewTab(false),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make('Hapus')
                    ->icon('heroicon-o-trash')
                    ->label('Hapus Terpilih')
                    ->successNotificationTitle('Surat terpilih berhasil dihapus.'),
            ])
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
            'index' => ListArsipSurats::route('/'),
            'create' => CreateArsipSurat::route('/create'),
            'view' => ViewArsipSurat::route('/{record}'),
            'edit' => EditArsipSurat::route('/{record}/edit'),
        ];
    }
}
