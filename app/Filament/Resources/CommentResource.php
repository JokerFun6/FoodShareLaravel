<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Filament\Resources\CommentResource\RelationManagers;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;
    protected static ?string $pluralModelLabel = 'Комментарии';
    protected static ?string $modelLabel = 'Комментарий';
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-oval-left-ellipsis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'login')
                    ->required()
                    ->label('Автор'),
                Forms\Components\Select::make('recipe_id')
                    ->relationship('recipe', 'title')
                    ->required()
                    ->label('Рецепт'),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull()
                    ->label('Описание'),
                Forms\Components\FileUpload::make('photo_url')
                    ->image()
                    ->directory('сomments')
                    ->label('Фотография')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable()
                    ->label('Автор'),
                Tables\Columns\TextColumn::make('recipe.title')
                    ->numeric()
                    ->sortable()
                    ->label('Рецепт'),
                Tables\Columns\TextColumn::make('description')
                    ->columnSpanFull()
                    ->label('Описание')
                    ->limit(),
                Tables\Columns\ImageColumn::make('photo_url')
                    ->square()
                    ->label('Фотография'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Дата публикации'),
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
            'index' => Pages\ManageComments::route('/'),
        ];
    }
}
