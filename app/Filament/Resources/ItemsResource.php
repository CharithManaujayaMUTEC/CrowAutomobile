<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemsResource\Pages;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ItemsResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Inventory';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('item_brand_id')
                ->relationship('itemBrand', 'name')
                ->searchable()
                ->label('Brand'),

            Forms\Components\Select::make('unit')
                ->options([
                    'l'    => 'Liters',
                    'ml'   => 'Milliliters',
                    'pcs'  => 'Pieces',
                    'pair' => 'Pair',
                ])
                ->required(),

            Forms\Components\TextInput::make('qty')
                ->numeric()
                ->required(),

            Forms\Components\Textarea::make('comment')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('itemBrand.name')
                    ->label('Brand')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('unit')
                    ->sortable(),

                Tables\Columns\TextColumn::make('qty')
                    ->sortable(),

                Tables\Columns\TextColumn::make('comment')
                    ->limit(30),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageItems::route('/'),
        ];
    }
}
