<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Mail;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $pluralModelLabel = 'Пользователи';
    protected static ?string $modelLabel = 'Пользователь';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

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

                Tables\Columns\TextColumn::make('reason_ban')
                    ->label('Причина блокирования')
                    ->toggleable(isToggledHiddenByDefault: true),


                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Дата регистрации'),
            ])
            ->filters([
                Filter::make('admin')
                    ->toggle()
                    ->label('Администраторы')
                    ->query(fn (Builder $query): Builder => $query->where('admin', true))

            ])
            ->actions([
//              Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->fillForm(fn (User $record): array => [
                        'comment' => $record->reason_ban,
                    ])
                    ->form([
                        Forms\Components\TextInput::make('comment')
                            ->label('Причина блокировки')
                            ->required(fn(User $record) => $record->ban === 0),
                    ])
                    ->action(function (array $data, User $record)
                    {
                        $record->reason_ban = $record->ban === 0 ? $data['comment'] : null;
                        $record->ban = !$record->ban;
                        $record->save();
                    })
                    ->label(function(User $record){
                        return $record->ban === 1 ? "Разблокировать" : "Заблокировать";
                     })
                    ->modalHeading(function(User $record){
                        return $record->ban === 1 ? "Разблокировать пользователя" : "Заблокировать пользователя";
                    })
                    ->modalDescription('')
                    ->modalSubmitActionLabel('Да')
                    ->modalIcon('heroicon-o-user')
                    ->icon('heroicon-m-user-minus')
                    ->color(function(User $record){
                        return $record->ban === 1 ? 'success' : "danger";
                    })

//                    ->requiresConfirmation(),

//                Action::make('sendEmail')
//                    ->form([
//                        TextInput::make('subject')->required(),
//                        RichEditor::make('body')->required(),
//                    ])
//                    ->action(function (array $data) {
//                        Mail::to($this->client)
//                            ->send(new GenericEmail(
//                                subject: $data['subject'],
//                                body: $data['body'],
//                            ));
//                    })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),

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
//            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
