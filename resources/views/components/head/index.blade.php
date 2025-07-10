@props([
    'title' => '',
    'breadcrumbs' => null,
    'button' => null,
])

<div class="mb-4 sm:mb-4">
    <div class="mx-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-2">
        <div class="flex flex-col gap-1 sm:gap-0 sm:w-1/2">
            <flux:heading size="lg" level="1">
                {{ $title }}
            </flux:heading>

            {{ $breadcrumbs ?? '' }}
        </div>

        <flux:spacer />

        {{ $button ?? '' }}
    </div>
</div>
