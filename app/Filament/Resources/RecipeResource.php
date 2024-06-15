<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecipeResource\Pages;
use App\Filament\Resources\RecipeResource\RelationManagers;
use App\Models\Recipe;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class RecipeResource extends Resource
{
    protected static ?string $model = Recipe::class;
    protected static ?string $pluralModelLabel = 'Рецепты';
    protected static ?string $modelLabel = 'Рецепт';
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (string $state, Forms\Set $set, $operation){
                            if ($operation === 'edit'){
                                return ;
                            }
                            $set('slug_title', Str::slug($state));
                        })
                        ->maxLength(100)
                        ->label('Название'),
                    Forms\Components\TextInput::make('slug_title')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->validationMessages([
                            'unique' => 'Этот слаг уже занят.',
                        ])
                        ->label('Слаг'),
                    Forms\Components\Textarea::make('description')
                        ->columnSpanFull()
                        ->label('Описание'),
                    Forms\Components\TextInput::make('preparation_time')
                        ->required()
                        ->numeric()
                        ->label('Время приготовления'),
                    Forms\Components\TextInput::make('amount_services')
                        ->required()
                        ->numeric()
                        ->postfix('Минут')
                        ->label('Количество порций'),
                    Forms\Components\Select::make('complexity')
                        ->required()
                        ->options([
                            'легкий' => 'Легкий',
                            'средний' => 'Средний',
                            'сложный' => 'Сложный',
                        ])
                        ->label('Сложность'),
                    Forms\Components\FileUpload::make('photo_url')
                        ->image()
                        ->disk('public')
                        ->directory('recipes_data')
                        ->imageEditor()
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('16:9')
                        ->imageResizeTargetWidth('800')
                        ->imageResizeTargetHeight('450')
                        ->rules([
                            'image',
                            'dimensions:min_width=800,min_height=450'])
                        ->validationMessages([
                            'dimension' => 'Минимальные размеры изображения: 800 * 450',
                        ])
                        ->label('Изображение'),

                    Forms\Components\TextInput::make('cost')
                        ->numeric()
                        ->suffix('Руб')
                        ->label('Стоимость'),

                    Forms\Components\Select::make('user_id')
                        ->relationship('user', 'login')
                        ->label('Автор')
                        ->disabledOn('edit'),

                    Forms\Components\Select::make('tags')
                        ->relationship('tags', 'title')
                        ->label('Категории')
                        ->multiple()
                        ->preload()
                        ->native(),

                    Forms\Components\Select::make('nationality_id')
                        ->relationship('nationality', 'title')
                        ->searchable(['title'])
                        ->label('Кухня'),
                    Forms\Components\Toggle::make('is_publish')
                        ->label('Опубликовать'),
                ])
                    ->columns(2)


                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('Название'),
                Tables\Columns\ImageColumn::make('photo_url')

                    ->label('Изображение'),
                Tables\Columns\TextColumn::make('user.login')
                    ->sortable()
                    ->badge()
                    ->label('Автор'),
                Tables\Columns\ToggleColumn::make('is_publish')
                    ->label('Опубликовать'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Дата создания'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\IngredientsRelationManager::class,
            RelationManagers\StepsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecipes::route('/'),
            'create' => Pages\CreateRecipe::route('/create'),
            'edit' => Pages\EditRecipe::route('/{record}/edit'),
        ];
    }
}
