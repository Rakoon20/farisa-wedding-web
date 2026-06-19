<?php

namespace App\Filament\Admin\Widgets;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Widgets\Widget;

class ReportsWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.admin.widgets.reports-widget';
    protected int|string|array $columnSpan = 2;

    public ?array $data = [];

    public function mount(): void
    {
        $this->data = [
            'start_date' => now()->startOfMonth()->toDateString(),
            'end_date'   => now()->endOfMonth()->toDateString(),
        ];
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('Tanggal Akhir')
                    ->required(),
            ])
            ->statePath('data');
    }

    public function exportExcel()
    {
        $data = $this->form->getState();
        return redirect()->route('admin.reports.excel', $data);
    }

    public function exportPdf()
    {
        $data = $this->form->getState();
        return redirect()->route('admin.reports.pdf', $data);
    }
}
