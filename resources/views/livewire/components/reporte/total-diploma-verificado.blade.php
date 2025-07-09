<x-card-stadistic title="Diplomas Verificados" number="{{ number_format($this->totalDiplomasVerificados, 0, '.', ',') }}">
    <x-slot:icon class="bg-green-500">
        <i class="ki-filled ki-check-squared text-4xl text-white"></i>
    </x-slot>
</x-card-stadistic>
