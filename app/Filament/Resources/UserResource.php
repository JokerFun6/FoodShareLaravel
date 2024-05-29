<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $pluralModelLabel = 'Пользователи';
    protected static ?string $modelLabel = 'Пользователь';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->maxLength(255)
                    ->label('Имя'),
                Forms\Components\TextInput::make('lastname')
                    ->maxLength(255)
                    ->label('Фамилия'),
                Forms\Components\Textarea::make('about_info')
                    ->columnSpanFull()
                    ->label('Информация о пользователе'),
                Forms\Components\TextInput::make('login')
                    ->required()
                    ->maxLength(255)
                    ->label('Логин'),
                Forms\Components\FileUpload::make('avatar_url')
                    ->image()
                    ->disk('public')
                    ->directory('users_data')
                    ->avatar()
                    ->imageEditor()
                    ->circleCropper()
                    ->label('Аватар'),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->label('Адрес почты'),
                Forms\Components\Toggle::make('admin')
                    ->required()
                    ->label('Админ'),


            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Имя'),
                Tables\Columns\TextColumn::make('lastname')
                    ->searchable()
                    ->label('Фамилия'),
                Tables\Columns\TextColumn::make('login')
                    ->searchable()
                    ->label('Логин'),
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->circular()
                    ->label('Аватар'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->label('Почта'),
                Tables\Columns\ToggleColumn::make('admin')
                    ->label('Админ'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Дата создания'),
            ])
            ->filters([
                Filter::make('admin')
                    ->toggle()
                    ->label('Администраторы')
                    ->query(fn (Builder $query): Builder => $query->where('admin', true))

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
