<?php

namespace App\Livewire\Components\Reporte;

use App\Models\GradoAcademico;
use App\Models\Registros;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy()]
class TotalDiploma extends Component
{
    public ?GradoAcademico $gradoAcademico;

    public function render()
    {
        return view('livewire.components.reporte.total-diploma');
    }

    public function mount($id_gac)
    {
        $this->gradoAcademico = GradoAcademico::find($id_gac);
    }

    #[Computed()]
    public function totalDiplomas()
    {
        return Registros::query()
            ->where('id_gac', $this->gradoAcademico->id_gac)
            ->count();
    }

    public function placeholder()
    {
        return <<<'HTML'
        <x-card-stadistic title="Total Diplomas" number="-">
            <x-slot:icon class="bg-accent">
                <i class="ki-filled ki-some-files text-4xl text-white"></i>
            </x-slot>
        </x-card-stadistic>
        HTML;
    }
}
