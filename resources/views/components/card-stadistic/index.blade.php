@props([
    'title' => 'Title',
    'number' => 0,
    'icon',
])

<x-card>
    <x-card.body>
        <div class="flex items-center justify-between">
            <div>
                <flux:text class="text-base md:text-md !font-semibold">{{ $title }}</flux:text>
                <p class="text-xl md:text-3xl font-bold text-zinc-800 dark:text-zinc-200">{{ $number }}</p>
            </div>
            <div
                {{ $icon->attributes->class(['flex items-center p-2.5 rounded-2xl shadow-xs border border-zinc-200 border-b-zinc-300/80 dark:border-zinc-600']) }}
            >
                {{ $icon }}
            </div>
        </div>
    </x-card.body>
</x-card>
