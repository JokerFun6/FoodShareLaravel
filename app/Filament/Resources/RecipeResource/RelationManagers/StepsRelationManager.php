<?php

namespace App\Filament\Resources\RecipeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StepsRelationManager extends RelationManager
{
    protected static string $relationship = 'steps';
    protected static ?string $title = 'Шаги';
    protected static ?string $label = 'Шаги';
    protected static ?string $pluralModelLabel = 'Шаги';
    protected static ?string $modelLabel = 'Шаг';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255)
                    ->label('Описание'),
                Forms\Components\FileUpload::make('photo_url')
                    ->image()
                    ->directory('recipes_data/steps')
                    ->imageEditor()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth('500')
                    ->imageResizeTargetHeight('281')
                    ->rules([
                        'image',
                        'dimensions:min_width=500,min_height=281'])
                    ->validationMessages([
                        'dimension' => 'Минимальные размеры изображения: 500 * 281',
                    ])
                    ->nullable()
                    ->label('Изображение'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Описание'),
                Tables\Columns\ImageColumn::make('photo_url')
                    ->label('Изображение')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
