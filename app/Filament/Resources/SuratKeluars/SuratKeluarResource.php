<?php

namespace App\Filament\Resources\SuratKeluars;

use Dom\Text;
use BackedEnum;
use Filament\Tables\Table;
use App\Models\SuratTerbit;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\SuratKeluars\Pages\EditSuratKeluar;
use App\Filament\Resources\SuratKeluars\Pages\ListSuratKeluars;
use App\Filament\Resources\SuratKeluars\Pages\CreateSuratKeluar;
use App\Filament\Resources\SuratKeluars\Schemas\SuratKeluarForm;
use App\Filament\Resources\SuratKeluars\Tables\SuratKeluarsTable;
use Faker\Core\File;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use PhpParser\Comment\Doc;

class SuratKeluarResource extends Resource
{
    protected static ?string $model = SuratTerbit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentArrowUp;

    protected static ?string $recordTitleAttribute = 'Surat Keluar';
    public static function getNavigationLabel(): string
    {
        return 'Surat Keluar';
    }
    protected static ?string $navigationLabel = 'Surat Keluar';
    protected static ?string $pluralLabel = 'Surat Keluar';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('nomor_surat')
                    ->label('Nomor Surat')
                    ->required(),
                TextInput::make('kepada')
                    ->label('Kepada')
                    ->required(),
                TextInput::make('tanggal_pengajuan')
                    ->label('Tanggal Pengajuan')
                    ->required(),
                FileUpload::make('file_pdf')
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pengajuan.nama')
                    ->label('Nama Pengaju')
                    ->searchable(),
                TextColumn::make('nomor_surat')
                    ->label('Nomor Surat')
                    ->searchable(),
                TextColumn::make('kepada')
                    ->label('Kepada')
                    ->searchable(),
                TextColumn::make('tanggal_pengajuan')
                    ->label('Tanggal Pengajuan')
                    ->date()
                    ->searchable(),

            ])
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
            'index' => ListSuratKeluars::route('/'),
            'create' => CreateSuratKeluar::route('/create'),
            'edit' => EditSuratKeluar::route('/{record}/edit'),
        ];
    }
}
