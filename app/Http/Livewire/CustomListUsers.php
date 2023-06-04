<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class CustomListUsers extends Component implements \Filament\Tables\Contracts\HasTable
{
    use \Filament\Tables\Concerns\InteractsWithTable;

    protected function getTableQuery(): Builder
    {
        return User::query();
    }

    public function render(): View
    {
        return view('custom-list-users');
    }

    protected function getTableColumns(): array
    {
        return [
            \Filament\Tables\Columns\TextColumn::make('title'),
            \Filament\Tables\Columns\TextColumn::make('author.name'),
        ];
    }

    protected function getTableFilters(): array
    {
        return [];
    }

    protected function getTableActions(): array
    {
        return [];
    }

    protected function getTableBulkActions(): array
    {
        return [];
    }

    // // https://filamentphp.com/docs/2.x/tables/getting-started#pagination
    // protected function isTablePaginationEnabled(): bool
    // {
    //     return false;
    // }

    // https://filamentphp.com/docs/2.x/tables/getting-started#pagination
    // protected function getTableRecordsPerPageSelectOptions(): array
    // {
    //     return [10, 25, 50, 100];
    // }

    protected function getTableEmptyStateIcon(): ?string
    {
        return 'heroicon-o-bookmark';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        return 'No posts yet';
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        return 'You may create a post using the button below.';
    }

    protected function getTableEmptyStateActions(): array
    {
        return [
            \Filament\Tables\Actions\Action::make('create')

                ->label('Create post')
                ->url(route('posts.create'))
                ->icon('heroicon-o-plus')
                ->button(),
        ];
    }
}
