<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IngredientResource\Pages;
use App\Filament\Resources\IngredientResource\RelationManagers;
use App\Models\Ingredient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class IngredientResource extends Resource
{
    protected static ?string $model = Ingredient::class;
    protected static ?string $pluralModelLabel = 'Ингредиенты';
    protected static ?string $modelLabel = 'Ингредиент';

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $state, Forms\Set $set){
                        $set('slug_title', Str::slug($state));
                    })
                    ->maxLength(100)
                    ->unique()
                    ->validationMessages([
                        'unique' => 'Этот ингредиент уже создан.',
                    ])
                    ->label('Название'),
                Forms\Components\TextInput::make('slug_title')
                    ->required()
                    ->maxLength(255)
                    ->readOnly()
                    ->label('Слаг'),
                Forms\Components\TextInput::make('calorie')
                    ->required()
                    ->numeric()
                    ->label('Каллорийность'),
                Forms\Components\TextInput::make('fats')
                    ->required()
                    ->numeric()
                    ->label('Жиры'),
                Forms\Components\TextInput::make('carbohydrates')
                    ->required()
                    ->numeric()
                    ->label('Углеводы'),
                Forms\Components\TextInput::make('protein')
                    ->required()
                    ->numeric()
                    ->label('Белок'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('Название'),
                Tables\Columns\TextColumn::make('slug_title')
                    ->searchable()
                    ->label('Слаг'),
                Tables\Columns\TextColumn::make('calorie')
                    ->numeric()
                    ->sortable()
                    ->label('Каллорийность'),
                Tables\Columns\TextColumn::make('fats')
                    ->numeric()
                    ->sortable()
                    ->label('Жиры'),
                Tables\Columns\TextColumn::make('carbohydrates')
                    ->numeric()
                    ->sortable()
                    ->label('Углеводы'),
                Tables\Columns\TextColumn::make('protein')
                    ->numeric()
                    ->sortable()
                    ->label('Белки'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ManageIngredients::route('/'),
        ];
    }
}
