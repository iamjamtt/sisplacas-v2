<?php

namespace App\Livewire\Components\Reporte;

use App\Enums\EstadoRegistroEnum;
use App\Models\GradoAcademico;
use App\Models\Registros;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy()]
class TotalDiplomaVerificado extends Component
{
    public ?GradoAcademico $gradoAcademico;

    public function render()
    {
        return view('livewire.components.reporte.total-diploma-verificado');
    }

    public function mount($id_gac)
    {
        $this->gradoAcademico = GradoAcademico::find($id_gac);
    }

    #[Computed()]
    public function totalDiplomasVerificados()
    {
        return Registros::query()
            ->where('estado_reg', EstadoRegistroEnum::ACTIVO)
            ->where('id_gac', $this->gradoAcademico->id_gac)
            ->count();
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-card-stadistic title="Diplomas Verificados" number="-">
            <x-slot:icon class="bg-green-500">
                <i class="ki-filled ki-check-squared text-4xl text-white"></i>
            </x-slot>
        </x-card-stadistic>
        HTML;
    }
}
