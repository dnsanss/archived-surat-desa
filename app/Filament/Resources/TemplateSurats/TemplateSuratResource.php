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

class TemplateSuratResource extends Resource
{
    protected static ?string $model = TemplateSurat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Template Surat';
    protected static ?string $pluralLabel = 'Template Surat';


    protected static ?string $recordTitleAttribute = 'Template Surat';

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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_template')
                    ->label('Nama Template')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y, H:i'),
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
            'view' => EditTemplateSurat::route('/{record}/view'),
        ];
    }
}
