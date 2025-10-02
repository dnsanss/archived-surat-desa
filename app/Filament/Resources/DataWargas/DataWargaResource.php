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
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\DataWargas\Pages\EditDataWarga;
use App\Filament\Resources\DataWargas\Pages\ListDataWargas;
use App\Filament\Resources\DataWargas\Pages\CreateDataWarga;
use App\Filament\Resources\DataWargas\Schemas\DataWargaForm;
use App\Filament\Resources\DataWargas\Tables\DataWargasTable;

class DataWargaResource extends Resource
{
    protected static ?string $model = DataWarga::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'DATA WARGA';

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
                ->unique(ignoreRecord: true)
                ->maxLength(16),

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

            Textarea::make('alamat')
                ->label('Alamat Lengkap')
                ->rows(2),

            TextInput::make('rt')->label('RT')->maxLength(3),
            TextInput::make('rw')->label('RW')->maxLength(3),

            TextInput::make('kelurahan')->label('Kelurahan'),
            TextInput::make('kecamatan')->label('Kecamatan'),

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

            TextInput::make('pekerjaan')->label('Pekerjaan'),
            TextInput::make('kewarganegaraan')
                ->label('Kewarganegaraan')
                ->default('WNI'),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->sortable(),

                TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->date()
                    ->sortable(),

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
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('delete')
                    ->label('Delete Selected')
                    ->action(fn(array $records) => DataWarga::whereIn('id', $records)->delete())
                    ->requiresConfirmation()
                    ->color('danger'),
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
            'index' => ListDataWargas::route('/'),
            'create' => CreateDataWarga::route('/create'),
            'edit' => EditDataWarga::route('/{record}/edit'),
        ];
    }
}
