<?php

namespace App\Filament\Resources\TemplateSurats;

use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use App\Models\TemplateSurat;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use function Laravel\Prompts\form;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\DeleteBulkAction;

use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use App\Filament\Resources\TemplateSurats\Pages\EditTemplateSurat;
use App\Filament\Resources\TemplateSurats\Pages\ListTemplateSurats;
use App\Filament\Resources\TemplateSurats\Pages\CreateTemplateSurat;
use App\Filament\Resources\TemplateSurats\Schemas\TemplateSuratForm;
use App\Filament\Resources\TemplateSurats\Tables\TemplateSuratsTable;
use Dom\Text;

class TemplateSuratResource extends Resource
{
    protected static ?string $model = TemplateSurat::class;

    // icon sidebar
    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentDuplicate;

    // label sidebar
    protected static ?string $navigationLabel = 'Template Surat';
    protected static ?string $pluralLabel = 'Template Surat';

    // title halaman
    protected static ?string $recordTitleAttribute = 'Template Surat';

    //menu input
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('nama_template')
                    ->label('Nama Template Surat')
                    ->required()
                    ->maxLength(255),

                RichEditor::make('isi_template')
                    ->label('Isi Template Surat')
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
                TextInput::make('nomor_surat')
                    ->label('Nomor Surat')
                    ->required()
                    ->maxLength(100),
            ]);
    }

    //menu tabel
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_template')
                    ->label('Nama Template')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y'),
                TextColumn::make('nomor_surat')
                    ->label('Nomor Surat')
                    ->searchable(),
            ])
            ->recordActions([
                ViewAction::make(),
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
            'index' => ListTemplateSurats::route('/'),
            'create' => CreateTemplateSurat::route('/create'),
            'edit' => EditTemplateSurat::route('/{record}/edit'),
        ];
    }
}
