<x-card-stadistic title="Registros del mes" number="{{ number_format($this->totalDiplomasDelMes, 0, '.', ',') }}">
    <x-slot:icon class="bg-cyan-500">
        <i class="ki-filled ki-files text-5xl text-white"></i>
    </x-slot>
</x-card-stadistic>
