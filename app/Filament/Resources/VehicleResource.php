<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleResource\Pages;
use App\Filament\Resources\VehicleResource\RelationManagers;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationGroup = 'Registrations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('number')->required(),
                Forms\Components\Select::make('brand')->options([
                    'Toyota' => 'Toyota',
                    'Honda' => 'Honda',
                    'Suzuki' => 'Suzuki',
                    'Nissan' => 'Nissan',
                    'Mitsubishi' => 'Mitsubishi'
                ])->required(),
                Forms\Components\TextInput::make('model')->required(),
                Forms\Components\TextInput::make('milage')->required(),
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->required()->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    Tables\Columns\TextColumn::make('number')->sortable()->searchable()->weight(FontWeight::Bold)->icon('heroicon-s-identification')->alignCenter(),
                    Tables\Columns\TextColumn::make('brand')->sortable()->searchable()->icon('heroicon-s-globe-alt')->alignLeft(),
                    Tables\Columns\TextColumn::make('model')->sortable()->searchable()->icon('heroicon-s-cog')->alignLeft(),
                    Tables\Columns\TextColumn::make('milage')->sortable()->searchable()->icon('heroicon-s-check-badge')->alignLeft(),
                    Tables\Columns\TextColumn::make('customer.name')->label('Customer')->sortable()->searchable()->icon('heroicon-s-user')->alignLeft(),
                ]),
            ])->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->filters([
                //
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
            'index' => Pages\ManageVehicles::route('/'),
        ];
    }
}
