<div
    {{ $attributes->merge([
        'class' => 'p-1 bg-zinc-200/25 dark:bg-zinc-900/25 rounded-2xl shadow-2xs border border-zinc-200 dark:border-zinc-700',
    ]) }}
>
    {{ $slot }}
</div>
