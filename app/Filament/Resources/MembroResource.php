<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MembroResource\Pages;
use App\Models\Membro;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class MembroResource extends Resource
{
    protected static ?string $model = Membro::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required(),
                Forms\Components\TextInput::make('sobrenome'),
                Forms\Components\TextInput::make('nome_amigavel'),
                Forms\Components\TextInput::make('sexo'),
                Forms\Components\TextInput::make('status_enum'),
                Forms\Components\TextInput::make('tipo_enum'),
                Forms\Components\DateTimePicker::make('data_de_nascimento'),
                Forms\Components\DateTimePicker::make('membro_desde'),
                Forms\Components\DateTimePicker::make('primeiro_registro'),
                Forms\Components\Textarea::make('nota_publica'),
                Forms\Components\Textarea::make('nota_interna'),
                Forms\Components\Textarea::make('telefones'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome'),
                Tables\Columns\TextColumn::make('sobrenome')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('nome_amigavel')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('sexo')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('status_enum')
                    ->label('Ativo')
                    ->formatStateUsing(fn ($record) => match ($record->status_enum) {
                        Membro::STATUS_INATIVO => 'Inativo',
                        Membro::STATUS_ATIVO => 'Ativo',
                        default => '',
                    }),
                Tables\Columns\TextColumn::make('tipo_enum'),
                Tables\Columns\TextColumn::make('data_de_nascimento')
                    ->dateTime()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('membro_desde')
                    ->dateTime()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('primeiro_registro')
                    ->dateTime()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMembros::route('/'),
        ];
    }
}
