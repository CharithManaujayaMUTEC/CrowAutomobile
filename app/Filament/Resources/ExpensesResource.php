<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpensesResource\Pages;
use App\Filament\Resources\ExpensesResource\RelationManagers;
use App\Models\Expenses;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpensesResource extends Resource
{
    protected static ?string $model = Expenses::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = "Expences";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('expense_category_id')->required()->relationship('expenseCategories', 'name')->searchable(),
            Forms\Components\TextInput::make('name')->required(), 
            Forms\Components\TextInput::make('description')->required(), 
            Forms\Components\TextInput::make('date')->required()
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([Tables\Columns\TextColumn::make('name')->sortable()->searchable(), Tables\Columns\TextColumn::make('description')->sortable()->searchable(), Tables\Columns\TextColumn::make('date')->sortable()->searchable(), Tables\Columns\TextColumn::make('expense_category')->sortable()->searchable()])
            ->filters([
                //
            ])
            ->actions([Tables\Actions\ViewAction::make(), Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageExpenses::route('/'),
        ];
    }
}
