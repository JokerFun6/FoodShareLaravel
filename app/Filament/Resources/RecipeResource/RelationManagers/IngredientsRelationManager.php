<?php

namespace App\Filament\Resources\RecipeResource\RelationManagers;

use App\Filament\Resources\IngredientResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IngredientsRelationManager extends RelationManager
{
    protected static string $relationship = 'ingredients';
    protected static ?string $label = 'Ингредиент';
    protected static ?string $title = 'Ингредиенты';
    /**
     * @deprecated Override the `table()` method to configure the table.
     */
    protected static ?string $pluralLabel = 'Ингредиенты';
    /**
     * @deprecated Override the `table()` method to configure the table.
     */
    protected static ?string $modelLabel = 'Ингредиент';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('title')
                    ->required()
                    ->relationship('ingredients', 'title')
                    ->preload()
                    ->searchable()
                    ->label('Ингредиент')
                    ,
                Forms\Components\Select::make('measure')
                    ->required()
                    ->options([
                        'кг' => 'килограмм',
                        'гр' => 'грамм',
                        'ст. л' => 'столовых ложек',
                        'ч. л' => 'чайных ложек',
                        'мл' => 'милилитров',
                        'л' => 'литров',
                        'шт' => 'штук',
                    ])
                    ->label('Величина'),
                Forms\Components\TextInput::make('value')
                    ->numeric()
                    ->required()
                    ->label('Количество'),
                Forms\Components\TextInput::make('comment')
                    ->label('Примечание'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Ингредиент')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Количество'),
                Tables\Columns\TextColumn::make('measure')
                    ->label('Величина'),
                Tables\Columns\TextColumn::make('comment')
                    ->label('Примечание'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\Select::make('measure')
                            ->required()
                            ->options([
                                'кг' => 'килограмм',
                                'гр' => 'грамм',
                                'ст. л' => 'столовых ложек',
                                'ч. л' => 'чайных ложек',
                                'мл' => 'милилитров',
                                'л' => 'литров',
                                'шт' => 'штук',
                            ])
                            ->label('Величина'),
                        Forms\Components\TextInput::make('value')
                            ->numeric()
                            ->required()
                            ->label('Количество'),
                        Forms\Components\TextInput::make('comment')
                            ->required()
                            ->label('Примечание'),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
