<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventoResource\Pages;
use App\Models\Evento;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class EventoResource extends Resource
{
    protected static ?string $model = Evento::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('titulo')
                    ->required(),
                Forms\Components\Textarea::make('descricao'),
                Forms\Components\DateTimePicker::make('previsao_inicio'),
                Forms\Components\DateTimePicker::make('previsao_fim'),
                Forms\Components\DateTimePicker::make('data_inicio'),
                Forms\Components\DateTimePicker::make('data_fim'),
                Forms\Components\Textarea::make('nota_interna'),
                Forms\Components\TextInput::make('status_enum'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('titulo'),
                Tables\Columns\TextColumn::make('descricao'),
                Tables\Columns\TextColumn::make('previsao_inicio')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('previsao_fim')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('data_inicio')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('data_fim')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('nota_interna'),
                Tables\Columns\TextColumn::make('status_enum'),
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
            'index' => Pages\ManageEventos::route('/'),
        ];
    }
}
