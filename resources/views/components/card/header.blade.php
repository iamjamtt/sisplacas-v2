@props([
    'titulo' => null,
    'descripcion' => null,
    'accion' => null,
])


<div
    {{ $attributes->class([
        'overflow-hidden rounded-xl border border-zinc-200 bg-white text-zinc-800 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 flex justify-between items-center',
        'p-4' => !$accion,
        'px-4 py-2' => $accion,
    ]) }}
>
    <div class="flex flex-col gap-1">
        @if ($titulo)
            <flux:heading size="lg">
                {{ $titulo }}
            </flux:heading>
        @endif
        @if ($descripcion)
            <flux:text>
                {{ $descripcion }}
            </flux:text>
        @endif
    </div>

    <div class="flex gap-2">
        {{ $accion }}
    </div>

    {{ $slot }}
</div>
