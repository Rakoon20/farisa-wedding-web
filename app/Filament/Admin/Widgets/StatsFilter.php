<?php

namespace App\Filament\Admin\Widgets;

use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Session;

class StatsFilter extends Widget implements HasForms
{
    use InteractsWithForms;

    protected int|string|array $columnSpan = 'full';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'start_date' => Session::get('stats_start_date'),
            'end_date' => Session::get('stats_end_date'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->nullable(),
                DatePicker::make('end_date')
                    ->label('Tanggal Akhir')
                    ->nullable(),
            ])
            ->statePath('data');
    }

    public function filter(): void
    {
        $data = $this->form->getState();
        Session::put('stats_start_date', $data['start_date']);
        Session::put('stats_end_date', $data['end_date']);
        $this->dispatch('refresh-stats');
    }

    public function resetFilter(): void
    {
        Session::forget(['stats_start_date', 'stats_end_date']);
        $this->form->fill([
            'start_date' => null,
            'end_date' => null,
        ]);
        $this->dispatch('refresh-stats');
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('filament.admin.widgets.stats-filter', [
            'form' => $this->form,
        ]);
    }
}
