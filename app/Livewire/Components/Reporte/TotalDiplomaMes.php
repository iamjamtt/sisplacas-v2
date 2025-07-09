<?php

namespace App\Livewire\Components\Reporte;

use App\Enums\EstadoRegistroEnum;
use App\Models\Registros;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy()]
class TotalDiplomaMes extends Component
{
    public function render()
    {
        return view('livewire.components.reporte.total-diploma-mes');
    }

    #[Computed()]
    public function totalDiplomasDelMes()
    {
        return Registros::query()
            ->whereBetween('creado_en_reg', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])
            ->where('estado_reg', EstadoRegistroEnum::ACTIVO)
            ->count();
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-card-stadistic title="Registros del mes" number="-">
            <x-slot:icon class="bg-cyan-500">
                <i class="ki-filled ki-files text-5xl text-white"></i>
            </x-slot>
        </x-card-stadistic>
        HTML;
    }
}
