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
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use App\Filament\Resources\PengajuanSurats\Pages\EditPengajuanSurat;
use App\Filament\Resources\PengajuanSurats\Pages\ListPengajuanSurats;
use App\Filament\Resources\PengajuanSurats\Pages\CreatePengajuanSurat;

class PengajuanSuratResource extends Resource
{
    protected static ?string $model = PengajuanSurat::class;

    //icon sidebar
    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentText;

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
                    ->disabled()
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

                RichEditor::make('isi_surat')
                    ->label('Isi Surat')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'bulletList',
                        'orderedList',
                        'link',
                        'blockquote',
                        'codeBlock',
                    ])
                    ->columnSpanFull()
                    ->required(),
            ]);
    }


    //menampilkan data di tabel
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status')->badge()
                    ->colors([
                        'warning' => 'menunggu',
                        'info' => 'diproses',
                        'success' => 'selesai',
                    ])
                    ->label('Status')->searchable(),
                TextColumn::make('nik')->label('NIK')->searchable(),
                TextColumn::make('nama')->label('Nama Warga')->searchable(),
                TextColumn::make('template.nama_template')->label('Jenis Surat')->searchable(),
                TextColumn::make('nomor_surat')->label('Nomor Surat')->searchable(),
                TextColumn::make('tanggal_pengajuan')
                    ->label('Tanggal Pengajuan')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->searchable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make(),
                Action::make('proses')
                    ->label('Proses Surat')
                    ->icon('heroicon-o-document-check')
                    ->color('success')
                    ->action(function ($record) {
                        // Jalankan proses surat
                        $controller = app(\App\Http\Controllers\ProsesSuratController::class);
                        $controller->generate($record->id);

                        Notification::make()
                            ->title('Surat berhasil diproses!')
                            ->success()
                            ->send();

                        // Redirect ke halaman surat keluar
                        return redirect()->route('filament.karangasem.resources.surat-keluars.index');
                    })
                    ->openUrlInNewTab(),
                EditAction::make(),
                DeleteAction::make(),

            ])
            ->bulkActions([
                DeleteBulkAction::make(),
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
            'index' => ListPengajuanSurats::route('/'),
            'create' => CreatePengajuanSurat::route('/create'),
            'edit' => EditPengajuanSurat::route('/{record}/edit'),
        ];
    }
}
