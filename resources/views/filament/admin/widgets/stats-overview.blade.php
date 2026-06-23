<div>
    <form wire:submit.prevent="filter" class="mb-4 flex flex-wrap items-end gap-3">
        {{ $form }}
        <x-filament::button type="submit" color="primary" size="sm">
            <i class="fas fa-filter mr-1"></i> Filter
        </x-filament::button>
        <x-filament::button type="button" color="gray" size="sm" wire:click="resetFilter">
            <i class="fas fa-undo mr-1"></i> Reset
        </x-filament::button>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        @foreach($stats as $stat)
            @php
                $color = $stat->getColor() ?? 'gray';
                $icon = $stat->getIcon();
                $label = $stat->getLabel();
                $value = $stat->getValue();
                $description = $stat->getDescription();
            @endphp
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 transition hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ $label }}
                        </p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                            {{ $value }}
                        </p>
                        @if($description)
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                {{ $description }}
                            </p>
                        @endif
                    </div>
                    <div class="p-2 rounded-full bg-{{ $color }}-100 dark:bg-{{ $color }}-900/30">
                        @if($icon)
                            <x-dynamic-component :component="$icon" class="w-5 h-5 text-{{ $color }}-600 dark:text-{{ $color }}-400" />
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>