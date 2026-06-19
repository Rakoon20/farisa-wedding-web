<x-filament::widget>
    <x-filament::section>
        <h2 class="text-lg font-semibold mb-4">Generate Laporan Pendapatan</h2>
        <form wire:submit.prevent="export">
            {{ $this->form }}
            <div class="flex gap-2 mt-4">
                <x-filament::button wire:click="exportExcel" color="success" tag="button">
                    Download Excel
                </x-filament::button>
                <x-filament::button wire:click="exportPdf" color="danger" tag="button">
                    Download PDF
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>
</x-filament::widget>