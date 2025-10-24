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
use Dom\Text;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Facades\Date;

class PengajuanSuratResource extends Resource
{
    protected static ?string $model = PengajuanSurat::class;

    //icon sidebar
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    //label sidebar
    protected static ?string $navigationLabel = 'Pengajuan Surat Warga';
    protected static ?string $pluralLabel = 'Pengajuan Surat Warga';

    //menu input
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('nik')
                    ->label('NIK')
                    ->required()
                    ->length(16),

                TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->required(),

                Select::make('template_id')
                    ->label('Jenis Surat')
                    ->relationship('template', 'nama_template')
                    ->required(),

                TextInput::make('nomor_surat')
                    ->label('Nomor Surat')
                    ->default(fn($record) => $record?->template?->kode_nomor_surat ?? '')
                    ->disabled(fn($record) => $record?->status === 'selesai')
                    ->dehydrated(true)
                    ->required(),

                TextInput::make('kepada')
                    ->label('Kepada')
                    ->required(),

                DatePicker::make('tanggal_pengajuan')
                    ->label('Tanggal Pengajuan')
                    ->default(now())
                    ->required(),

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


    //menampilkan data di tabel
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nik')->label('NIK')->searchable(),
                TextColumn::make('nama')->label('Nama Warga')->searchable(),
                TextColumn::make('template.nama_template')->label('Jenis Surat')->searchable(),
                TextColumn::make('nomor_surat')->label('Nomor Surat')->searchable(),
                TextColumn::make('status')->badge()
                    ->colors([
                        'warning' => 'menunggu',
                        'info' => 'diproses',
                        'success' => 'selesai',
                    ])
                    ->label('Status')->searchable(),
                TextColumn::make('tanggal_pengajuan')
                    ->label('Tanggal Pengajuan')
                    ->dateTime('d M Y')
                    ->searchable(),
            ])
            ->defaultSort('tanggal_pengajuan', 'desc')
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
