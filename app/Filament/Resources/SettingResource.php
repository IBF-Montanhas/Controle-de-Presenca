<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Setting;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\DeleteAction;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\SettingResource\Pages;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('site_id'),

                Forms\Components\TextInput::make('name')
                    ->label(__('Config name'))
                    ->required(),

                Forms\Components\TextInput::make('key') // TODO make unique site_id+key
                    ->label(__('Config key')),

                Forms\Components\Select::make('type')
                    ->options([
                        Setting::TYPE_STRING => __('String'),
                        Setting::TYPE_BOOLEAN => __('Boolean'),
                        Setting::TYPE_NUMBER => __('Number'),
                        Setting::TYPE_JSON => __('JSON'),
                        Setting::TYPE_COLLECTION => __('Collection'),
                        Setting::TYPE_LONG_TEXT => __('Long text'),
                        Setting::TYPE_RICH_TEXT => __('Rich text'),
                    ])
                    ->default(Setting::TYPE_STRING)
                    ->required(),

                Forms\Components\TextInput::make('value_when_string'),

                Forms\Components\Textarea::make('value_when_long_text')
                    ->columnSpanFull(),

                Forms\Components\MarkdownEditor::make('value_when_rich_text')
                        ->helperText(
                            fn (Setting $record) =>
                            \App\Helpers\EasyHtml::make(
                                __('You can use Markdown instructions. :link', [
                                    'link' => '<a href="#linkDoc">' . __('See more') . '</a>' . (fn (Setting $record): string => $record->id)($record)
                                ])
                            )
                        )
                        ->toolbarButtons([
                            'attachFiles',
                            'bold',
                            'bulletList',
                            'codeBlock',
                            'edit',
                            'italic',
                            'link',
                            'orderedList',
                            'preview',
                            'strike',
                        ])
                        ->enableToolbarButtons([
                            'attachFiles',
                        ])
                        ->fileAttachmentsDirectory(
                            fn (Setting $record): string => \implode(
                                \DIRECTORY_SEPARATOR,
                                [
                                    'attachments',
                                    $record->site_id ? str($record->site_id)->slug('-') : '_general'
                                ]
                            )
                        )
                        ->fileAttachmentsVisibility('public')
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('value_when_json')
                    ->columnSpanFull(),

                Forms\Components\Select::make('value_when_boolean')
                    ->options([
                        true => __('true'),
                        false => __('false'),
                    ]),

                Forms\Components\TextInput::make('value_when_number')
                    ->numeric(),

                Forms\Components\Toggle::make('active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('site_id'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label(__('Setting'))
                    ->sortable(['key']),
                // Tables\Columns\TextColumn::make('key')->label(__('Config key')),
                Tables\Columns\TextColumn::make('formatedValueHideLongValues'),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('Type'))
                    ->sortable(['type'])
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            Setting::TYPE_STRING => __('String'),
                            Setting::TYPE_BOOLEAN => __('Boolean'),
                            Setting::TYPE_NUMBER => __('Number'),
                            Setting::TYPE_JSON => __('JSON'),
                            Setting::TYPE_COLLECTION => __('Collection'),
                            Setting::TYPE_LONG_TEXT => __('Long text'),
                            Setting::TYPE_RICH_TEXT => __('Rich text'),
                            default => '',
                        };
                    })
                    ->searchable([
                        'name',
                        'value_when_string',
                        'value_when_long_text',
                        'value_when_number',
                    ]),
                Tables\Columns\IconColumn::make('active')
                    // ->toggleable() ??
                    ->boolean()
                    ->action(
                        \Filament\Tables\Actions\Action::make('select')
                            ->label(
                                fn (Setting $record): string => $record->active
                                    ? __('Disable')
                                    : __('Enable')
                            )
                            ->requiresConfirmation()
                            ->modalSubheading(
                                fn (\Filament\Tables\Actions\Action $action): ?string =>
                                $action->getRecord()?->active
                                    ? __('Are you sure you want to disable the ":setting" setting?', [
                                        'setting' => $action->getRecord()?->name
                                    ])
                                    : __('Are you sure you want to enable the ":setting" setting?', [
                                        'setting' => $action->getRecord()?->name
                                    ])
                            )
                            ->action(function (Setting $record): void {
                                $record->update(['active' => !$record->active]);
                            }),
                    )
                    ->tooltip(
                        fn (Setting $record): string => $record->active
                            ? __('Disable')
                            : __('Enable')
                    ),
            ])
            ->filters([
                \Filament\Tables\Filters\TernaryFilter::make('active')
                    ->nullable()
                    ->attribute('active')
                    ->label(__('Active')),
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
                \Filament\Tables\Actions\DeleteAction::make()
                    ->hidden(fn (Setting $record): string => $record->can_be_deleted)
                    ->before(function (DeleteAction $action) {
                        $record = $action->getRecord();

                        if (!$record) {
                            return;
                        }

                        if (!$record->can_be_deleted) {
                            Notification::make()
                                ->warning()
                                ->title('You can\'t delete it!')
                                ->body('This setting can\'t be deleted.')
                                // ->persistent()
                                // ->actions([
                                //     Action::make('subscribe')
                                //         ->button()
                                //         ->url(route('subscribe'), shouldOpenInNewTab: true),
                                // ])
                                ->send();

                            // $action->halt();
                            $action->cancel();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    protected function shouldPersistTableSortInSession(): bool
    {
        return true;
    }

    protected function shouldPersistTableSearchInSession(): bool
    {
        return true;
    }

    protected function shouldPersistTableColumnSearchInSession(): bool
    {
        return true;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSettings::route('/'),
        ];
    }
}
