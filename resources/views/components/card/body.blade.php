<div
    {{ $attributes->merge([
        'class' => 'p-4 overflow-hidden rounded-xl border border-zinc-200 bg-white text-zinc-800 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100',
    ]) }}
>
    {{ $slot }}
</div>
