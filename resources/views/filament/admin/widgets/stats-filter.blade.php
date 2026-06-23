<div>
    <form wire:submit.prevent="filter" class="flex flex-wrap items-end gap-3">
        {{ $form }}
        <x-filament::button type="submit" color="primary" size="sm">
            <i class="fas fa-filter mr-1"></i> Filter
        </x-filament::button>
        <x-filament::button type="button" color="gray" size="sm" wire:click="resetFilter">
            <i class="fas fa-undo mr-1"></i> Reset
        </x-filament::button>
    </form>
</div>