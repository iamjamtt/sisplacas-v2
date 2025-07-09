<flux:dropdown position="top" align="start">
    <flux:profile
        :avatar:name="$usuario->name . ' ' . $usuario->last_name"
        avatar:color="auto"
    />
    <flux:navmenu>
        <div class="px-2 py-1.5">
            <flux:text size="sm">
                Bienvenido
            </flux:text>
            <flux:heading class="mt-1! truncate">
                {{ $usuario->name . ' ' . $usuario->last_name }}
            </flux:heading>
        </div>
        <flux:navmenu.separator />
        <livewire:components.cerrar-sesion.index />
    </flux:navmenu>
</flux:dropdown>
