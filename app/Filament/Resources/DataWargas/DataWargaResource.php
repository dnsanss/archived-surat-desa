<?php

namespace App\Filament\Resources\DataWargas;

use BackedEnum;
use Livewire\Form;
use App\Models\DataWarga;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use function Laravel\Prompts\select;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Collection;
use App\Filament\Resources\DataWargas\Pages\EditDataWarga;
use App\Filament\Resources\DataWargas\Pages\ListDataWargas;
use App\Filament\Resources\DataWargas\Pages\CreateDataWarga;

use App\Filament\Resources\DataWargas\Schemas\DataWargaForm;
use App\Filament\Resources\DataWargas\Tables\DataWargasTable;

class DataWargaResource extends Resource
{
    protected static ?string $model = DataWarga::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    public static function getNavigationLabel(): string
    {
        return 'Data Warga';
    }


    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('nik')
                ->label('NIK')
                ->required()
                ->minLength(16)
                ->maxLength(16)
                ->rule('digits:16')
                ->unique(ignoreRecord: true),

            TextInput::make('nama')
                ->label('Nama Lengkap')
                ->required(),

            TextInput::make('tempat_lahir')
                ->label('Tempat Lahir')
                ->required(),

            DatePicker::make('tanggal_lahir')
                ->label('Tanggal Lahir')
                ->required(),

            Select::make('jenis_kelamin')
                ->label('Jenis Kelamin')
                ->options([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ])
                ->required(),

            Select::make('alamat')
                ->label('Alamat')
                ->options([
                    'Krajan' => 'Krajan',
                    'Karanganyar Barat' => 'Karanganyar Barat',
                    'Karanganyar Timur' => 'Karanganyar Timur',
                    'Karanganyar Tengah' => 'Karanganyar Tengah',
                    'Karanganyar Kidul' => 'Karanganyar Kidul',
                ])
                ->required(),

            Select::make('rt')
                ->label('RT')
                ->options([
                    '001' => '001',
                    '002' => '002',
                    '003' => '003',
                    '004' => '004',
                    '005' => '005',
                    '006' => '006',
                    '007' => '007',
                    '008' => '008',
                    '009' => '009',
                    '010' => '010',
                    '011' => '011',
                    '012' => '012',
                    '013' => '013',
                    '014' => '014',
                    '015' => '015',
                    '016' => '016',
                    '017' => '017',
                    '018' => '018',
                    '019' => '019',
                    '020' => '020',
                    '021' => '021',
                ])
                ->required(),
            Select::make('rw')
                ->label('RW')
                ->options([
                    '001' => '001',
                    '002' => '002',
                    '003' => '003',
                    '004' => '004',
                    '005' => '005',
                    '006' => '006',
                    '007' => '007',
                    '008' => '008',
                    '009' => '009',
                ])
                ->required(),

            TextInput::make('kelurahan')
                ->label('Kelurahan')
                ->default('Karangasem')
                ->required(),
            TextInput::make('kecamatan')
                ->label('Kecamatan')
                ->default('Lumbang')
                ->required(),

            Select::make('agama')
                ->label('Agama')
                ->options([
                    'Islam' => 'Islam',
                    'Kristen' => 'Kristen',
                    'Katolik' => 'Katolik',
                    'Hindu' => 'Hindu',
                    'Buddha' => 'Buddha',
                    'Konghucu' => 'Konghucu',
                ])
                ->required(),

            Select::make('status_perkawinan')
                ->label('Status Perkawinan')
                ->options([
                    'Belum Kawin' => 'Belum Kawin',
                    'Kawin' => 'Kawin',
                    'Cerai Hidup' => 'Cerai Hidup',
                    'Cerai Mati' => 'Cerai Mati',
                ])
                ->required(),

            TextInput::make('pekerjaan')->label('Pekerjaan')->required(),
            TextInput::make('kewarganegaraan')
                ->label('Kewarganegaraan')
                ->default('WNI')
                ->required(),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable(),

                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable(),

                TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin'),

                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->limit(30),

                TextColumn::make('pekerjaan')
                    ->label('Pekerjaan')
                    ->limit(20),
            ])
            ->filters([
                SelectFilter::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ]),
                SelectFilter::make('agama')
                    ->label('Agama')
                    ->options([
                        'Islam' => 'Islam',
                        'Kristen' => 'Kristen',
                        'Katolik' => 'Katolik',
                        'Hindu' => 'Hindu',
                        'Buddha' => 'Buddha',
                        'Konghucu' => 'Konghucu',
                    ]),
                SelectFilter::make('alamat')
                    ->label('Alamat')
                    ->options([
                        'Krajan' => 'Krajan',
                        'Karanganyar Barat' => 'Karanganyar Barat',
                        'Karanganyar Timur' => 'Karanganyar Timur',
                        'Karanganyar Tengah' => 'Karanganyar Tengah',
                        'Karanganyar Kidul' => 'Karanganyar Kidul',
                    ]),
                SelectFilter::make('status_perkawinan')
                    ->label('Status Perkawinan')
                    ->options([
                        'Belum Kawin' => 'Belum Kawin',
                        'Kawin' => 'Kawin',
                        'Cerai Hidup' => 'Cerai Hidup',
                        'Cerai Mati' => 'Cerai Mati',
                    ]),
            ])
            ->defaultSort('nama', 'asc')
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make('Hapus')
                    ->icon('heroicon-o-trash')
                    ->label('Hapus Terpilih')
                    ->successNotificationTitle('Data warga terpilih berhasil dihapus.'),
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
            'index' => ListDataWargas::route('/'),
            'create' => CreateDataWarga::route('/create'),
            'edit' => EditDataWarga::route('/{record}/edit'),
        ];
    }
}
