<?php

namespace App\Filament\Resources\DataWargas;

use BackedEnum;
use App\Models\DataWarga;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\DataWargas\Pages\EditDataWarga;
use App\Filament\Resources\DataWargas\Pages\ListDataWargas;
use App\Filament\Resources\DataWargas\Pages\CreateDataWarga;
use Filament\Tables\Filters\Filter;

class DataWargaResource extends Resource
{
    protected static ?string $model = DataWarga::class;

    //icon sidebar
    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    //memanggil fungsi untuk menampilkan total warga, jumlah laki-laki, jumlah perempuan dari folder DataWargas/Widgets
    public static function getNavigationLabel(): string
    {
        return 'Data Warga';
    }
    protected static ?string $navigationLabel = 'Data Warga';
    protected static ?string $pluralLabel = 'Data Warga';
    protected static ?string $recordTitleAttribute = 'Data Warga';

    //menu input
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
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    if ($state) {
                        $umur = \Carbon\Carbon::parse($state)->age;
                        $set('umur', $umur);
                    } else {
                        $set('umur', null);
                    }
                }),

            TextInput::make('umur')
                ->label('Umur')
                ->disabled()
                ->dehydrated(true)
                ->numeric(),

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

            Select::make('pendidikan')
                ->label('Pendidikan')
                ->options([
                    'SD' => 'SD',
                    'SMP' => 'SMP',
                    'SMA' => 'SMA',
                    'Diploma 1' => 'Diploma 1',
                    'Diploma 2' => 'Diploma 2',
                    'Diploma 3' => 'Diploma 3',
                    'Diploma 4' => 'Diploma 4',
                    'Sarjana' => 'Sarjana',
                    'Magister' => 'Magister',
                    'Doktor' => 'Doktor',
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

    //menampilkan data di tabel
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

                TextColumn::make('umur')
                    ->label('Umur')
                    ->searchable(),

                TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->searchable(),

                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->limit(30)
                    ->searchable(),

                TextColumn::make('pekerjaan')
                    ->label('Pekerjaan')
                    ->limit(20)
                    ->searchable(),
            ])
            ->filters([
                Filter::make('custom_filter')
                    ->schema([
                        Select::make('column')
                            ->label('Pilih Kolom')
                            ->options([
                                'agama' => 'Agama',
                                'jenis_kelamin' => 'Jenis Kelamin',
                                'pendidikan' => 'Pendidikan',
                                'umur' => 'Umur',
                                'alamat' => 'Alamat',
                                'status_perkawinan' => 'Status Perkawinan',
                            ])
                            ->reactive(),

                        // Jika kolom umur dipilih, tampilkan opsi perbandingan (>, <, =)
                        Select::make('operator')
                            ->label('Perbandingan Umur')
                            ->options([
                                '>' => 'Lebih dari',
                                '<' => 'Kurang dari',
                                '=' => 'Sama dengan',
                            ])
                            ->visible(fn($get) => $get('column') === 'umur')
                            ->reactive(),

                        // Field nilai filter (dinamis: dropdown atau input angka)
                        Select::make('value')
                            ->label('Pilih Nilai')
                            ->options(function (callable $get) {
                                return match ($get('column')) {
                                    'agama' => [
                                        'Islam' => 'Islam',
                                        'Kristen' => 'Kristen',
                                        'Katolik' => 'Katolik',
                                        'Hindu' => 'Hindu',
                                        'Budha' => 'Budha',
                                        'Konghucu' => 'Konghucu',
                                    ],
                                    'jenis_kelamin' => [
                                        'L' => 'Laki-Laki',
                                        'P' => 'Perempuan',
                                    ],
                                    'pendidikan' => [
                                        'SD' => 'SD',
                                        'SMP' => 'SMP',
                                        'SMA' => 'SMA',
                                        'Diploma' => 'Diploma',
                                        'Sarjana' => 'Sarjana',
                                        'Magister' => 'Magister',
                                        'Doktor' => 'Doktor',
                                    ],
                                    'status_perkawinan' => [
                                        'Belum Kawin' => 'Belum Kawin',
                                        'Kawin' => 'Kawin',
                                        'Cerai Hidup' => 'Cerai Hidup',
                                        'Cerai Mati' => 'Cerai Mati',
                                    ],
                                    'alamat' => [
                                        'Krajan' => 'Krajan',
                                        'Karanganyar Barat' => 'Karanganyar Barat',
                                        'Karanganyar Timur' => 'Karanganyar Timur',
                                        'Karanganyar Tengah' => 'Karanganyar Tengah',
                                        'Karanganyar Kidul' => 'Karanganyar Kidul',
                                    ],
                                    default => [],
                                };
                            })
                            ->visible(fn($get) => filled($get('column')) && $get('column') !== 'umur')
                            ->reactive(),

                        // Input umur khusus (muncul kalau kolom umur dipilih)
                        TextInput::make('umur_value')
                            ->label('Masukkan Umur')
                            ->numeric()
                            ->visible(fn($get) => $get('column') === 'umur'),
                    ])
                    ->query(function ($query, array $data) {
                        if (! $data['column']) return $query;

                        // Logika filter umur (numerik)
                        if ($data['column'] === 'umur') {
                            if (!empty($data['operator']) && isset($data['umur_value'])) {
                                return $query->where('umur', $data['operator'], $data['umur_value']);
                            }
                            return $query;
                        }

                        // Logika filter biasa (teks/enum)
                        if (!empty($data['value'])) {
                            return $query->where($data['column'], $data['value']);
                        }

                        return $query;
                    }),
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
            'index' => ListDataWargas::route('/'),
            'create' => CreateDataWarga::route('/create'),
            'edit' => EditDataWarga::route('/{record}/edit'),
        ];
    }
}
