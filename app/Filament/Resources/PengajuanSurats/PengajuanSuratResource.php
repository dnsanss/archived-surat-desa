<?php

namespace App\Filament\Resources\PengajuanSurats;

use BackedEnum;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use App\Models\PengajuanSurat;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\PengajuanSurats\Pages\EditPengajuanSurat;
use App\Filament\Resources\PengajuanSurats\Pages\ListPengajuanSurats;
use App\Filament\Resources\PengajuanSurats\Pages\CreatePengajuanSurat;
use App\Filament\Resources\PengajuanSurats\Schemas\PengajuanSuratForm;
use App\Filament\Resources\PengajuanSurats\Tables\PengajuanSuratsTable;

class PengajuanSuratResource extends Resource
{
    protected static ?string $model = PengajuanSurat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Inbox;
    protected static ?string $navigationLabel = 'Pengajuan Surat Warga';
    protected static ?string $pluralLabel = 'Pengajuan Surat Warga';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('nik')
                    ->label('NIK')
                    ->required()
                    ->length(16)
                    ->disabledOn('edit'),

                TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->required()
                    ->disabledOn('edit'),

                Select::make('template_id')
                    ->label('Jenis Surat')
                    ->relationship('template', 'nama_template')
                    ->required()
                    ->disabledOn('edit'),

                Textarea::make('catatan')
                    ->label('Catatan Tambahan')
                    ->rows(3)
                    ->nullable(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'diproses' => 'Diproses',
                        'selesai' => 'Selesai',
                    ])
                    ->default('menunggu')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nik')->label('NIK')->searchable(),
                TextColumn::make('nama')->label('Nama Warga')->searchable(),
                TextColumn::make('template.nama_template')->label('Jenis Surat')->sortable(),
                TextColumn::make('status')->badge()
                    ->colors([
                        'warning' => 'menunggu',
                        'info' => 'diproses',
                        'success' => 'selesai',
                    ]),
                TextColumn::make('created_at')
                    ->label('Tanggal Pengajuan')
                    ->dateTime('d M Y, H:i'),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make(),
                Action::make('proses')
                    ->label('Proses Surat')
                    ->icon('heroicon-o-document-check')
                    ->color('success')
                    ->url(fn($record) => route('admin.proses-surat', $record))
                    ->openUrlInNewTab(),
                EditAction::make(),
                DeleteAction::make(),

            ])
            ->bulkActions([
                DeleteBulkAction::make(),
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
            'index' => ListPengajuanSurats::route('/'),
            'create' => CreatePengajuanSurat::route('/create'),
            'edit' => EditPengajuanSurat::route('/{record}/edit'),
        ];
    }
}
